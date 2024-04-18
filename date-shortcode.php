<?php
/*
Plugin Name: Easy Date Shortcodes
Description: Adds shortcodes for displaying the current year, month, day, and time with the ability to offset the values and specify a custom date.
Version: 1.1
Author: Axel Hansson
Author URI: https://buffert.se
*/

// Register filter hooks for various elements where dates may need to be dynamically inserted or modified.
add_filter("the_title", "process_shortcode_in_title");
add_filter("rank_math/frontend/breadcrumb/settings", "process_shortcode_in_breadcrumbs");
add_filter("rank_math/frontend/breadcrumb/strings", "process_shortcode_in_breadcrumbs");
add_filter("rank_math/frontend/breadcrumb/html", "process_shortcode_in_breadcrumbs");
add_filter("rank_math/frontend/title", "process_shortcode_in_seo_elements");
add_filter("rank_math/frontend/description", "process_shortcode_in_seo_elements");
add_filter("wpseo_title", "process_shortcode_in_seo_elements");
add_filter("wpseo_metadesc", "process_shortcode_in_seo_elements");
add_filter("wpseo_opengraph_title", "process_shortcode_in_seo_elements");
add_filter("single_post_title", "process_shortcode_in_title");

// Functions to process shortcodes in various contexts, improving readability and potential for specialized processing
function process_shortcode_in_title($title) {
    return do_shortcode($title);
}

function process_shortcode_in_breadcrumbs($breadcrumbs) {
    return do_shortcode($breadcrumbs);
}

function process_shortcode_in_seo_elements($seo_content) {
    return do_shortcode($seo_content);
}

// Enqueue CSS on the plugin options page only
function enqueue_options_page_css() {
    $screen = get_current_screen();
    if ($screen->id === "settings_page_date-format-options") {
        wp_enqueue_style("options-page-css", plugin_dir_url(__FILE__) . "options-page.css");
    }
}
add_action("admin_enqueue_scripts", "enqueue_options_page_css");

// Helper function for handling date shortcodes with offset and custom formatting
function handle_date_shortcode($atts, $type) {
    $offset = isset($atts['offset']) ? intval($atts['offset']) : 0;
    $format = isset($atts['format']) ? wp_kses($atts['format'], []) : get_option("{$type}_format", 'F');
    $timestamp = strtotime("+{$offset} {$type}");
    return esc_html(date($format, $timestamp));
}

// Define shortcodes for year, month, day, and time
function year_shortcode($atts) {
    return handle_date_shortcode($atts, 'year');
}
add_shortcode('year', 'year_shortcode');

function month_shortcode($atts) {
    return handle_date_shortcode($atts, 'month');
}
add_shortcode('month', 'month_shortcode');

function day_shortcode($atts) {
    return handle_date_shortcode($atts, 'day');
}
add_shortcode('day', 'day_shortcode');

function time_shortcode($atts) {
    return handle_date_shortcode($atts, 'seconds');
}
add_shortcode('time', 'time_shortcode');

// Define a complex date shortcode that allows custom year, month, and day inputs
function date_shortcode($atts) {
    $year = isset($atts["year"]) ? intval($atts["year"]) : date("Y");
    $month = isset($atts["month"]) ? intval($atts["month"]) : date("m");
    $day = isset($atts["day"]) ? intval($atts["day"]) : date("d");
    $format = isset($atts["format"]) ? wp_kses($atts["format"], []) : get_option("date_format", "F j, Y");
    $timestamp = strtotime("{$year}-{$month}-{$day}");
    return esc_html(date($format, $timestamp));
}
add_shortcode("date", "date_shortcode");

// Include separate file for options page to keep the main plugin file clean
include 'options-page.php';

// Register settings for the plugin options page
function register_date_format_options() {
    register_setting("date_format_options", "timezone");
    register_setting("date_format_options", "month_format");
    register_setting("date_format_options", "day_format");
    register_setting("date_format_options", "time_format");
    register_setting("date_format_options", "date_format");
}
add_action("admin_init", "register_date_format_options");

// Set the timezone based on plugin settings for consistent date outputs
function date_shortcode_locale() {
    $timezone = get_option("timezone", "UTC");
    if (!date_default_timezone_set($timezone)) {
        date_default_timezone_set('UTC'); // Fallback to UTC if invalid timezone
    }
}
add_action("wp", "date_shortcode_locale");

// Load plugin textdomain for localization
function date_shortcode_load_textdomain() {
    load_plugin_textdomain("date-shortcodes", false, basename(dirname(__FILE__)) . "/languages");
}
add_action("plugins_loaded", "date_shortcode_load_textdomain");
