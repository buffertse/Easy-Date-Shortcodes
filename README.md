# Easy Date Shortcodes

Welcome to the GitHub repository for the Easy Date Shortcodes plugin for WordPress! This plugin makes it super simple to add dynamic date information to your posts, pages, and widgets. Whether you need to display the current year, month, day, or even time — Easy Date Shortcodes has you covered.

## Features

- **Dynamic Dates**: Automatically update the year, month, or day in your WordPress content.
- **Shortcodes for Everything**: Use simple shortcodes to insert dates and times anywhere on your site.
- **Customizable**: Offset dates and times as needed and format them just the way you want.
- **SEO Friendly**: Integrates seamlessly with popular SEO plugins like Yoast SEO and Rank Math for dynamic date updating in meta tags.

## Installation

1. **Download the Plugin**:
   - Clone this repository or download the zip file and unzip it into your WordPress plugins directory.
   - Alternatively, you can download directly from the WordPress plugins directory once uploaded there.

2. **Activate the Plugin**:
   - Go to the 'Plugins' menu in WordPress and activate the Easy Date Shortcodes plugin.

3. **Configure Settings (Optional)**:
   - Navigate to the settings page under `Settings > Easy Date Shortcode Options` to adjust default formats and set your timezone.

## Usage

Using the plugin is straightforward. Here are the shortcodes you can use along with examples on how to apply offsets:

- **[year]**
  - Displays the current year. 
  - **Example with offset**: `[year offset="-1"]` displays last year. `[year offset="1"]` displays next year.

- **[month]**
  - Displays the current month. Customize the format as needed.
  - **Example with offset**: `[month offset="-1"]` displays the previous month. Use negative or positive numbers to adjust backward or forward respectively.

- **[day]**
  - Displays the current day. Supports formatting.
  - **Example with offset**: `[day offset="-1"]` displays yesterday. `[day offset="1"]` displays tomorrow.

- **[time]**
  - Displays the current time. Format the time output using standard PHP date formats.
  - **Example with offset**: `[time offset="3600"]` displays one hour ahead. Use seconds to adjust time.

- **[date year="2020" month="1" day="20"]**
  - Displays a custom date. All attributes are optional.
  - **Example with full custom date**: `[date year="2020" month="1" day="20"]` displays January 20, 2020.
  - **Example with current date and format**: `[date format="Y-m-d"]` displays today's date in YYYY-MM-DD format.

These shortcodes can be inserted into any post, page, or widget where shortcodes are processed, giving you flexibility in how you display dates and times on your WordPress site.
## Contributing

Contributions are what make the open-source community such an amazing place to learn, inspire, and create. Any contributions you make are **greatly appreciated**.

1. Fork the Project
2. Create your Feature Branch (`git checkout -b feature/AmazingFeature`)
3. Commit your Changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the Branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

Distributed under the MIT License.

## Contact

Axel Hansson - [@buffertse](https://twitter.com/@buffertse) - axel.hansson@buffert.se

Project Link: [https://github.com/buffertse/Easy-Date-Shortcodes](https://github.com/buffertse/Easy-Date-Shortcodes)
