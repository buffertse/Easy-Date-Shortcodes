<?php
/*
Plugin Name: Easy Date Shortcodes
Description: Adds shortcodes for displaying the current year, month, day, and time with the ability to offset the values and specify a custom date.
Version: 1.0
Author: Axel Hansson
Author URI: https://buffert.se
*/

add_filter("the_title", "date_shortcode_title");
add_filter("rank_math/frontend/breadcrumb/settings", "date_shortcode_title");
add_filter("rank_math/frontend/breadcrumb/strings", "date_shortcode_title");
add_filter("rank_math/frontend/breadcrumb/html", "date_shortcode_title");
add_filter("rank_math/frontend/title", "date_shortcode_title");
add_filter("rank_math/frontend/description", "date_shortcode_title");
add_filter("wpseo_title", "date_shortcode_title");
add_filter("wpseo_metadesc", "date_shortcode_title");
add_filter("wpseo_opengraph_title", "date_shortcode_title");
function date_shortcode_title($title)
{
    return do_shortcode($title);
}
add_filter("single_post_title", "date_shortcode_title");

function enqueue_options_page_css()
{
    $screen = get_current_screen();
    if ($screen->id === "settings_page_date-format-options") {
        wp_enqueue_style(
            "options-page-css",
            plugin_dir_url(__FILE__) . "options-page.css"
        );
    }
}
add_action("admin_enqueue_scripts", "enqueue_options_page_css");

function year_shortcode($atts)
{
    $offset = isset($atts["offset"]) ? intval($atts["offset"]) : 0;
    $timestamp = strtotime("+{$offset} year");
    return date("Y", $timestamp);
}
add_shortcode("year", "year_shortcode");
function month_shortcode($atts)
{
    $offset = isset($atts["offset"]) ? intval($atts["offset"]) : 0;
    $format = isset($atts["format"])
        ? wp_kses($atts["format"], [])
        : get_option("month_format", "F");
    $timestamp = strtotime("+{$offset} month");
    return esc_html(date($format, $timestamp));
}
add_shortcode("month", "month_shortcode");

function day_shortcode($atts)
{
    $offset = isset($atts["offset"]) ? intval($atts["offset"]) : 0;
    $format = isset($atts["format"])
        ? wp_kses($atts["format"], [])
        : get_option("day_format", "j");
    $timestamp = strtotime("+{$offset} day");
    return esc_html(date($format, $timestamp));
}
add_shortcode("day", "day_shortcode");

function time_shortcode($atts)
{
    $offset = isset($atts["offset"]) ? intval($atts["offset"]) : 0;
    $format = isset($atts["format"])
        ? wp_kses($atts["format"], [])
        : get_option("time_format", "g:i a");
    $timestamp = strtotime("+{$offset} seconds");
    return esc_html(date($format, $timestamp));
}
add_shortcode("time", "time_shortcode");

function date_shortcode($atts)
{
    $year = isset($atts["year"]) ? intval($atts["year"]) : date("Y");
    $month = isset($atts["month"]) ? intval($atts["month"]) : date("m");
    $day = isset($atts["day"]) ? intval($atts["day"]) : date("d");
    $format = isset($atts["format"])
        ? wp_kses($atts["format"], [])
        : get_option("date_format", "F j, Y");
    $timestamp = strtotime("{$year}-{$month}-{$day}");
    return esc_html(date($format, $timestamp));
}
add_shortcode("date", "date_shortcode");

function options_page()
{
    add_options_page(
        "Easy Date Shortcode Options",
        "Easy Date Shortcode",
        "manage_options",
        "date-format-options",
        "date_format_options_page"
    );
}
add_action("admin_menu", "options_page");

function date_format_options_page()
{
    if (isset($_POST["submit"])) {
        update_option("timezone", sanitize_text_field($_POST["timezone"]));
        update_option(
            "month_format",
            sanitize_text_field($_POST["month_format"])
        );
        update_option("day_format", sanitize_text_field($_POST["day_format"]));
        update_option(
            "time_format",
            sanitize_text_field($_POST["time_format"])
        );
        update_option(
            "date_format",
            sanitize_text_field($_POST["date_format"])
        );
    }
    $timezone = get_option("timezone", "UTC");
    $month_format = get_option("month_format", "F");
    $day_format = get_option("day_format", "j");
    $time_format = get_option("time_format", "g:i a");
    $date_format = get_option("date_format", "F j, Y");
    ?>
  <div class="wrap">
  
  <form action="options.php" method="post">
    <?php settings_fields("date_format_options"); ?>
    <?php do_settings_sections("date-format-options"); ?>
    <table class="form-table">
<h1>Easy Date Shortcode Options</h1>
      <tr valign="top">
        <th scope="row">Timezone</th>
        <td>
          <select name="timezone">
            <?php foreach (timezone_identifiers_list() as $tz): ?>
              <option value="<?php echo $tz; ?>" <?php selected(
    $tz,
    $timezone
); ?>>
                <?php echo $tz; ?>
              </option>
            <?php endforeach; ?>
          </select>
          <p class="description">Select the timezone to use for the shortcodes.</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Month Format</th>
        <td>
          <input type="text" name="month_format" value="<?php echo esc_attr(
              $month_format
          ); ?>" />
          <p class="description">Enter the default format for the month shortcode. For example, "F" will display the full month name (e.g. "January"), and "M" will display the abbreviated month name (e.g. "Jan").</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Day Format</th>
        <td>
          <input type="text" name="day_format" value="<?php echo esc_attr(
              $day_format
          ); ?>" />
          <p class="description">Enter the default format for the day shortcode. For example, "j" will display the day of the month without leading zeros (e.g. "1"), and "d" will display the day of the month with leading zeros (e.g. "01").</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Time Format</th>
        <td>
          <input type="text" name="time_format" value="<?php echo esc_attr(
              $time_format
          ); ?>" />
          <p class="description">Enter the default format for the time shortcode. For example, "g:i a" will display the time in a 12-hour format (e.g. "1:00 pm"), and "H:i" will display the time in a 24-hour format (e.g. "13:00").</p>
        </td>
      </tr>
      <tr valign="top">
        <th scope="row">Date Format</th>
        <td>
          <input type="text" name="date_format" value="<?php echo esc_attr(
              $date_format
          ); ?>" />
          <p class="description">Enter the default format for the date shortcode. For example, "F j, Y" will display the date in a long form (e.g. "January 1, 2022"), and "Y-m-d" will display the date in a numeric form (e.g. "2022-01-01").</p>
        </td>
      </tr>
    </table>
    <?php submit_button(); ?>
  </form>  </div>
  <?php
}

function register_date_format_options()
{
    register_setting("date_format_options", "timezone");
    register_setting("date_format_options", "month_format");
    register_setting("date_format_options", "day_format");
    register_setting("date_format_options", "time_format");
    register_setting("date_format_options", "date_format");
}
add_action("admin_init", "register_date_format_options");

function date_shortcode_locale()
{
    $timezone = get_option("timezone", "UTC");
    date_default_timezone_set($timezone);
}
add_action("wp", "date_shortcode_locale");

function date_shortcode_load_textdomain()
{
    load_plugin_textdomain(
        "date-shortcodes",
        false,
        basename(dirname(__FILE__)) . "/languages"
    );
}
add_action("plugins_loaded", "date_shortcode_load_textdomain");