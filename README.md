**PROJECT BACKGROUND**

The goal of this project is to help us understand how you approach software development challenges when they are presented under real-world circumstances, as opposed to a high-pressure, quiz-style interview. The project is intended for candidates with software development knowledge, but no prior full-time experience as a developer. You will be given a task to complete, specifications explaining what the finished product must look like, and a date by which to complete it. 

You are free to use any resources you like to research the type of development you will need to do; we will also point you to some publicly available documentation that we think will help you get started. You should also feel free to use whatever tools and processes you normally employ to write code, and you should stage and deploy your code however you feel comfortable doing so.

**SPECIFICATIONS**

Your task is to build a plugin for WordPress. The plugin’s purpose is to fetch data from a REST API endpoint which reports fictional stock price updates, and provide a widget using the WordPress Widget API to allow a site administrator to display the data publicly.

The following requirements apply to the plugin:

* [X] It must be possible to install and enable the plugin on a fresh installation of the latest version of WordPress without errors or other obvious problems.

* [X] The plugin must extend the base *WP_Widget* class.

* [X] The widget type provided by the plugin must present a configuration form, allowing the site administrator to enter a personalized API key for access to the REST API, and to select how many stock price updates they wish to display in the widget.

* [X] The widget must display stock price data fetched from the endpoint within the last 1 minute.

* [ ] The plugin must use the administrator-provided API key to generate a signed hash for its requests to the endpoint (the endpoint will not return data without it).

* [X] The plugin must handle any possible response from the endpoint gracefully, and may not display error messages, inaccurate information, or broken markup due to not having valid data to show.

* [X] Both the administrator configuration form and the public widget display must use properly formatted, semantic HTML5 to render form elements and fetched data.

**DOCUMENTATION**

This page explains the details of the API we are providing for you. This API provides fictional data and is not documented elsewhere on the Internet. It has been created specifically for this test project.

* [API specifications](http://apidemo.alley.ws/documentation.html)

These pieces of documentation come from the Codex, WordPress’s official compendium of developer documentation. They describe various components of WordPress that you will need to use to complete this plugin.

* [Widget API](https://codex.wordpress.org/Widgets_API) – Describes the *WP_Widget* class that you must extend to create your own widget type, and shows what methods need to be implemented to provide configuration and display functionality for it.

* [HTTP API](https://codex.wordpress.org/HTTP_API) – Describes functions included in WordPress core that allow you to retrieve data from a remote URL.

* [Writing a Plugin](https://codex.wordpress.org/Writing_a_Plugin) – Covers some basic information about how to create your own plugin for WordPress; in particular note [this](https://developer.wordpress.org/plugins/the-basics/header-requirements/) link from that page which explains the required PHP header comment necessary to make WordPress recognize your plugin.

* [Transients API ](https://codex.wordpress.org/Transients_API)– Discusses "transients", which is WordPress’s term for pieces of cached data.

* [Data Validation](https://codex.wordpress.org/Data_Validation) – Lists and describes useful built-in functions in WordPress to sanitize and escape your data to avoid security issues and vulnerabilities.

**DELIVERY**

We will create a private Github repository attached to Alley Interactive’s organization Github account, and provide you with push access to it. You will need to create a Github account if you do not have one yet. You should deliver your finished code to us by committing and pushing it to this repository.

**TIME, COMPENSATION, AND INTELLECTUAL PROPERTY**

We believe the plugin described in this document should be possible to build in approximately four (4) hours or less for someone with substantial programming knowledge who is comfortable with PHP but has had no prior contact with WordPress. The amount of time it actually takes you may vary. If you find it substantially more than four hours, or you feel you are stuck and cannot proceed further, submit what you have and email us an explanation of what requirements you were not able to meet and what you think the problem is.

Alley Interactive does not believe in spec work. We think your time is valuable. We will pay you a fixed rate of $200 for undertaking this test project upon delivery of your solution to us, regardless of the outcome of your candidacy.

We would like you to complete the project within five (5) business days after receiving these specifications. If you are unable to do so for logistical reasons, please let us know so we can work out an alternate schedule.

It is important to keep this test and your solution private in order to protect the validity of the process. You should only push this code to the private Github repository that we provide for you. By accepting payment for this code, you acknowledge that your finished work becomes the property of Alley Interactive and that you may not use it for other purposes unless we direct you to do so. You also acknowledge that this specification document, and the API endpoint we are providing, are the confidential property of Alley Interactive and may not be shared with anyone else without our permission.

**ORIGINAL WORK AND OUTSIDE HELP**

You can and should consult the WordPress codex, PHP documentation, StackOverflow, programming books, and other freely available information on the Internet or in print to help you formulate your solution to this challenge. However, **do not** seek outside help from other people for this project, and **do not** include any code in your finished work that is copied verbatim from another source. 

We understand certain types of code structures may necessarily be identical to examples you find on the Internet, so we place our trust in you that you will not violate the spirit of this exercise by receiving outside help or copying existing code. The bond of trust between all members of Alley Interactive’s team is core to our success and mission as an organization, and your conduct during this challenge is part of that bond.

