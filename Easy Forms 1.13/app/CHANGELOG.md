# Changelog


07.04.2021 - ver 1.13

- Added: PHP 7.4 support
- Added: Amazon SES Integration
- Added: Form Builder: Add/Move fields before first form component
- Added: Feature to set the "Date / Time Format" in the entire app
- Added: Dashboard. "Unread Submissions" panel
- Added: Select email field for Email Notifications > CC and BCC
- Added: Ability to add event types dynamically with add-ons
- Added: Dynamic Content: {{ submission_text }} variable
- Added: Theme Manager: "Copy a Theme" 
- Added: "Save a Theme & Continue" feature.
- Added: Protected Files: Allow authorized request by using API keys
- Improved: Don't use default no-reply email address with Form emails
- Improved: Copy Form adds "Copy" to the name
- Improved: Form Builder: Without Name nor Title shows error message
- Improved: Url Redirection with Dynamic Content
- Improved: Compatibility with Subscription module
- Improved: GridView: Update Date Range Format.
- Improved: Avoid duplicated submission numbers when they are saved at the same second
- Improved: Publish Forms: Display Application Name in embed code
- Improved: Uses Hash ID to identify a form publicly
- Improved: Implements support for SVG images (logo)
- Improved: Update module: SetupHelper trigger event before migration
- Improved: Update module: Removes the "version restriction" to access it.
- Improved: Vendor & Libraries
- Fixed: ImageHelper. Detect if an uploaded file is an image
- Fixed: IIS and json files incompatibility
- Fixed: DataValidator: Textarea > minLength/maxLength validation
- Fixed: Error when anonymous users access restricted pages (UserPreferences)
- Fixed: Update add-ons with DB prefix
- Fixed: Demo of jQuery UI Datepicker in French
- Fixed: Form Builder: Matrix Field and Label CSS Class
- Fixed: Disable User Registration page
- Fixed: Search submissions in Arabic language
- Removed: "Save To DB" column from Form Manager
- Removed: JsonToArrayBehavior & ArrayAccess library


16.01.2021 - ver 1.12.3

- Added: Submit Form with Conditional Logic
- Added: Reset Form with Conditional Logic
- Added: Go to Next or Previous Page with Conditional Logic 
- Added: Submission Manager: Referrer Page to Sender's Information
- Added: Submission Manager: Adds Url and Referrer to Export Submissions
- Added: Form Builder: Hide Navigation Buttons with Theme Designer
- Improved: "Export Submissions" and Encrypted Fields Ad-On Integration
- Improved: Submission Manager with horizontal scrollbar
- Improved: Redirect to Dashboard when a user goes the Form page without permissions
- Improved: reCAPTCHA v3: Refresh expired tokens with very large forms.
- Improved: Rule Builder: Update choices when a Radio Button / Select List was updated
- Improved: Setup: Update DB config file after the Test Connection
- Improved: Vendors and libraries.
- Fixed: Required File fields and Conditional Validation
- Fixed: Verify user permissions to re-send email notifications
- Fixed: Incompatibility with IIS Server
- Fixed: "No results" message in Submission Manager
- Fixed: Incompatibility between Yii2 and Progress Bar


22.09.2020 - ver 1.12.2

- Added: Dynamic Content: Date Filter with Timezone
- Improved: Disable SSL verification during Browser Geolocation
- Improved: Compatibility between the Rule Builder (Formula) and jQuery selectors
- Improved: Compatibility between Data Validator and add-ons
- Fixed: Display logo when the application has been installed in a sub-folder
- Fixed: Rule Engine: Incompatibility between Format Text and Matrix Fields
- Fixed: Update Confirmation message with redirection
- Fixed: Email Notifications > Replace a Checkbox Field variable
- Fixed: Update / Delete logo


03.09.2020 - ver 1.12.1

- Added: Report Builder: Filter data by date range
- Improved: Print Submission Report design
- Fixed: Show/Delete logo image when App has been installed in a sub-folder 
- Fixed: Show error messages in a multi-step form (Matrix field)
- Fixed: Show validation error messages in other languages (Matrix field)
- Fixed: REST API > Form Submissions end-point.
- Fixed: Form Tools > Update Form Builder (Templates)
- Fixed: Responsive design of Gridview (Form Manager)


15.08.2020 - ver 1.12

- Added: Submission Management: Re-Send Email notifications and Confirmation Emails
- Added: Form Settings > Own Scope: Allow users to manage their own submissions only
- Added: New placeholder: {{edit_link}}
- Added: Form Settings > Editable: Allow Edit Form Submissions in Form Widget
- Added: Browser Geolocation (Google Maps integration)
- Added: Form Settings > IP Tracking
- Added: Form Settings > Private Forms (Internal Forms)
- Added: Form Settings > Text Direction
- Added: Confirmation Emails > Attach uploaded files to autoresponder 
- Added: Form Settings > Protected files
- Added: Date Calculations with Conditional Logic
- Added: User Account > Generate API key
- Added: REST API module
- Added: Dynamic Content (Template language)
- Improved: Submission Manager > Submission Details page > Show public edit link
- Improved: Site Settings > API and API keys
- Improved: Limit submissions from the same User by Browser Fingerprint
- Improved: Form Builder: Adds Alias to Matrix Field
- Improved: Open multiple pop-up forms on the same page
- Improved: Install script shows alert message when PHP version is before PHP 5.6.0
- Improved: "uploads" folder structure
- Improved: Vendors updated
- Fixed: Form Tracker url
- Fixed: Create Theme > "Shared" default option
- Fixed: Separate paragraphs in Submission Details page
- Fixed: Sending confirmation emails to CC and BCC emails addresses
- Fixed: Submission Manager: Fix issue updating uploaded files
- Fixed: Form Widget: Fix issue sending headers into the request
- Fixed: DataValidator > Field Number (Min number)
- Fixed: Form Builder > Theme designer > Label > Font Weight
- Fixed: Date-Time local field validation
- Fixed: Form Builder: Check if an email field has been removed
- Fixed: Incompatibility between Form Stats and MariaDB below v10.3
- Fixed: Rule Engine when an element doesn't exist
- Fixed: reCAPTCHA missing-input-response


15.06.2020 - ver 1.11.2

- Added: Form Builder. Add form components with a click
- Added: Rule Builder: Name/Describe conditional rules
- Improved: Form Builder: Updates text of alert message
- Improved: Pop-Up Forms and Multi-Step forms
- Improved: Form Builder: Performance in Theme Designer
- Improved: Form Builder: Updates javascript libraries
- Improved: Form Builder: Save Form's height
- Improved: Form Builder: Choice with single quotes
- Improved: Scroll to top in downloaded forms
- Fixed: Compatibility between Multi-Step forms and "change" event
- Fixed: Form Widget: Load selected google font
- Fixed: Update a non-submitted checkbox value
- Fixed: Form Settings: Fix mistyped word
- Fixed: Data validator when a unique field hasn't a data label
- Fixed: Logout link with disabled pretty urls


02.06.2020 - ver 1.11.1

- Fixed: Form Builder: Mouse click & drag events issue (In some devices).
- Fixed: Form Builder: Color picker design in Safari.


01.06.2020 - ver 1.11

- Added: Share forms with QR Codes
- Added: Form Page. Edit form submissions by passing a parameter in URL
- Added: Rule Engine: Formula. Compare value of different fields.
- Added: Placeholder Autocomplete Tool in Form Settings and Rule Builder
- Added: Evaluate Math Formula with Conditional Rules
- Added: Custom no-reply email address in Email Notifications
- Added: Form Builder: File Field with support for multiple files
- Added: Form Builder: "Copy source code" feature.
- Added: Form Builder: Option to display Help Text above inputs
- Added: Form Builder: Unique validation for Hidden Fields
- Added: Form Builder: Minlength and Maxlength validation
- Added: Form Builder: Alias in Signature Field
- Added: Form Builder: Matrix Field
- Added: File fields (links) to placeholder replacement (field variables).
- Added: Submission ID to Excel and CSV Exports
- Added: Form Widget: postMessage to parent windows when a form event occurs
- Added: Select Form Field as Name or Company in Notification Settings
- Added: Identify super admins with the source code
- Added: Form Widget & Form End-Point: Update a Form Submission
- Added: Form Builder: "Choices" in Field Settings
- Added: Form Builder: Scrollbar in Field Settings
- Added: Demo JS file: jQuery UI Datepicker in French
- Improved: "Empty Fields" checkbox in Submission Details page
- Improved: Form Builder: Field Settings. Moves checkboxes to the end and improves UI
- Improved: Update Form Builder Fields Tool: Not add "alias" option to Spacer field.
- Improved: Form Stats compatibility with MariaDB (below 10.2)
- Improved: Detects when server uses https with a reverse proxy (nginx)
- Improved: Enables "Remember Me" feature in Form Login
- Improved: Disable Session Timeout in Form Builder
- Fixed: Copy conditional rules in Confirmation Settings
- Fixed: Form Builder: Radio Button -> font-size
- Fixed: i18n in conditional rules
- Fixed: Save Form with opened popover
- Fixed: Hide a Snippet field with conditional rules
- Fixed: Sendinblue component: Reply-to field
- Fixed: Form Builder: Snippet field (Wysiwyg editor)
- Removed: Form Builder: Field Settings "More" link


13.04.2020 - ver 1.10.3

- Added: Submission Number in Export Submissions tool.
- Improved: Logs during the installation process.
- Improved: RBAC - Form Rule Builder Access.
- Improved: User Registration redirects to Login page.
- Improved: Redirect users to Login page after Reset password or Confirm email.
- Improved: Setup. Improves installation with MySQL versions below 5.7
- Improved: Vendors and libraries.
- Fixed: Setup warning message: Session already started.
- Fixed: Installation process. Incompatibility with table prefix.
- Fixed: Captcha in User Registration Form.
- Fixed: Issues sending emails. 
- Fixed: Uses App Name configuration as application name in email messages.
- Fixed: Redirect to login page for anonymous users.
- Fixed: Send email notifications to email field with double opt-in event.
- Fixed: Cron Job with Sendinblue notifications.


29.03.2020 - ver 1.10.2

- Improved: Show alert messages on Dashboard after install/update process.
- Improved: Changes App default route to "user/login" when user is guest
- Improved: Disable add-ons when "Update" module has been enabled
- Improved: Access Control for RuleBuilderAction (Conditions Builder widget)
- Fixed: Session Timeout
- Fixed: Form Tracker


26.03.2020 - ver 1.10.1

- Improved: Support for PHP 5.6, 7.0, 7.1, 7.2 and 7.3.
- Removed: Drop support for PHP 5.5.


25.03.2020 - ver 1.10

- Added: Customize From Name in Notification Emails
- Added: Allow / Disallow "Unconfirmed Email" users in login
- Added: Impersonate Users with switch back to your account.
- Added: Login options to Site Settings
- Added: Shared Add-Ons to User Roles.
- Added: Email Notification to Email Fields.
- Added: Two Factor Authentication
- Added: Shared Resources: Forms, Templates, Themes and Add-Ons
- Added: New RBAC system
- Added: New User System
- Improved: Support for PHP 7.2 and 7.3.
- Improved: Vendors and libraries.
- Improved: Add-On Manager: Feature to update add-on settings.
- Improved: Form Builder: Multi-Steps Forms: No stages. Change color and bg-color.
- Improved: Migration: Increase PHP memory and time limits for long duration process.
- Improved: GridView: "Sharing" column. Identifies shared resources state.
- Improved: GridView: Updated by and Updated columns
- Improved: Google Analytics Add-On: v1.1. Implements RBAC system.
- Improved: CRUD of User Roles to assign granular permissions
- Improved: WebHooks Add-On: v1.3. Supports RBAC system.
- Fixed: Pre-fill form fields with Url Parameters (empty spaces)
- Fixed: Rule Engine: Ends with (When target string is smaller than actual string)
- Fixed: Multi-columns within radio/checkbox components.
- Fixed: Updates "Updated" column in Form Manager when Form Builder is saved
- Fixed: Updating logo when app has been installed within a folder.
- Fixed: Checkbox and Radio Button with Default Values.
- Fixed: Run rule engine when the form view event has been triggered.
- Fixed: Updating form stats with MySQL 5.7.
- Fixed: Export entries with files (Wrong files order)
- Fixed: Form Embed: Removes "g-recaptcha" class with reCAPTCHA v3
- Fixed: iPhone issue: Iframe container width
- Fixed: Customize From Name in Confirmation Settings
- Fixed: Submission Helper issue about PHP namespace
- Fixed: Display GridView Filters on wide screens
- Removed: Drop support for PHP 5.4.


12.12.2019 - ver 1.9.1

- Added: Submission Table placeholder for email messages: {{submission_table}}
- Added: Mail Server settings -> Form Name configuration.
- Added: Update Login page slogan on Site Settings (Description).
- Added: reCAPTCHA v3 (Invisible reCAPTCHA) support.
- Added: Double Opt-In feature.
- Added: ConditionsBuilder widget, RuleBuilder action and Form Confirmation Rules.
- Improved: Show Field Alias to recognize two fields with the same label.
- Improved: Signature field compatibility with optional PDF Add-On.
- Improved: Security improvements. Only index.php and install.php files can be accessed.
- Improved: Submission Manager: Show first 4 columns by default
- Improved: Site Settings -> Logo. Accept only png, jpg, jpeg or gif.
- Improved: Theme Designer and "Download the HTML" integration.
- Improved: Default padding in Form design.
- Improved: Reset reCAPTCHA after get server-side validation errors
- Improved: Save GridView filters state (ON / OFF) as User preference.
- Improved: Checkbox and Radio Button with HTML code as Label and Value.
- Improved: Submission Manager Date Range selector with localized calendars.
- Improved: WebHooks Add-On. Send POST request without SSL verification.
- Improved: Form Confirmation Settings with new parameters.
- Improved: GridView responsive design. 
- Fixed: TinyMCE editor is removing the base URL.
- Fixed: Theme Designer and values equal to 0.
- Fixed: Select2 Email Field on Form Confirmation Settings.
- Fixed: Signature field on Submission Manager.
- Fixed: Form Builder Inline Layout


26.11.2019 - ver 1.9

- Added: Form Builder. Implements Form Designer.
- Added: Form Builder. Implements Font Family selector with Google fonts.
- Added: Form Builder. Implements Gradient Editor.
- Added: Form Builder. Implements Pattern Selector.
- Added: Form Builder. "Hide / Show Panel" feature.
- Added: Form Builder. Loading spinner.
- Added: Demo JS file to compare two fields with jQuery Validation.
- Improved: Rule Builder -> Remove conditions.
- Improved: Display month and year drop downs on Gridview Date Range filter.
- Improved: Use App Name with Send Test Email.
- Improved: Enables CURL as default web transport.
- Improved: Token Replacement with Conditional Rules (Disabled fields).
- Improved: Load .json files with IIS (Access-Control-Allow-Origin *).
- Improved: Enables CURL without SSL and log installation process.
- Improved: Disables PHP CLI verification on Installation process.
- Improved: Form Widget. DefaultValues and QueryStrings trigger 'change' events.
- Improved: Form Builder: Performance Optimizations.
- Improved: Public Form Page layout and public.css (flexibility).
- Improved: Form Widget. New calculation to send Height to parent window.
- Fixed: Submission Manager: Update Checkboxes and radio buttons.
- Fixed: Form Settings: Disable url conversion with the wysiwyg editor.
- Fixed: Issue with PHP 5.6 and Export Form Files.
- Fixed: Redirect to Confirmation URL with downloaded HTML files.
- Fixed: Data Validator: Fix select list validation.
- Fixed: Incompatibility between inline radio/checkbox and conditional rules.
- Fixed: Disable Client Side Validation on Submission Manager.
- Fixed: Download Form Files on Windows Server.
- Fixed: SMTP Settings with 'none' encryption.


01.10.2019 - ver 1.8

- Added: Form Builder: Signature Field
- Added: Form Builder: Spacer Field
- Added: Download Form Files with all the features
- Added: Send Test Email
- Added: Sendinblue integration to send all the transactional emails
- Added: Demo JS file to show how to redirect after 5 seconds
- Added: Demo JS file to display the Current Date with jQuery UI Datepicker
- Added: Conditional Rules for Signature Field
- Improved: Rule Builder: Switches OFF Client Side Validation
- Improved: Form Builder modal: Share this Form
- Improved: reCAPTCHA: Use CURL by default, if it's available
- Improved: Form Builder Grid System
- Improved: Set JSON as default format when a request haven't an Accept header
- Improved: GridView support of Old ICU versions
- Improved: Vendor files
- Fixed: Email Notifications in other languages
- Fixed: Install Easy Forms on Windows Server without a valid CLI.
- Fixed: GridView date range filter
- Removed: Guzzle library dependency


01.09.2019 - ver 1.7.2

- Added: "Import / Export" forms between different sites
- Added: Submission number (Custom start, width, prefix and suffix)
- Added: Form Builder: Adds Wysiwyg editor to the HTML Snippet field
- Added: "Replace Logo with an uploaded image" feature
- Added: CSS classes to display radios/checkboxes in multiple columns
- Added: Sample js file to display Select2 instead Select List fields
- Added: "Save and continue" button in Form Settings.
- Added: Trigger SubmissionMailEvent when a notification is being sent
- Added: TinyMCE 5 editor (Instead of Summernote)
- Improved: Mail Server Settings (PHP or SMTP). Async notifications.
- Improved: Console commands (Analytics, Queue and Cron).
- Improved: Print Submissions Report
- Improved: Form widget compatibility with add-on's validation messages
- Improved: Update add-on info only with the Refresh button
- Improved: Disable add-on when it was removed without uninstall it
- Improved: .htaccess file. Adds more restrictions
- Fixed: Form View page when form hasn't a last editor
- Fixed: Inline Checkbox/Radio Button in Safari (MacOS)
- Removed: Bower and Npm dependencies


01.08.2019 - ver 1.7.1

- Added: Form Endpoints
- Added: Download the HTML / CSS code of your Forms
- Improved: Default Language and Timezone for creating a user
- Improved: WebHooks Add-On includes uploaded file links
- Improved: Mysql queries to refresh stats
- Improved: Files. Moves 'avatars' and 'themes' to 'static_files/uploads'
- Improved: Bootstrap CSS v1.4.1
- Improved: Horizontal and Inline layouts for small screens
- Improved: Improved RTL design
- Improved: Checkbox and Radio Button designs with Less
- Improved: Vendor files
- Fixed: Issue creating user accounts
- Fixed: Updating Form Name based on Form Title


01.07.2019 - ver 1.7

- Added: Session Timeout: "Your session has expired"
- Added: Tool to update the number of rows of the GridView
- Added: 'User Preferences' feature
- Updated: Form Widget: New way to send body height to parent window
- Updated: RelationTrait to support Relation Validation
- Updated: Vendor files
- Updated: Stores Submission Manager settings as User Preferences
- Updated: Form Builder: Html Event Attributes are not allowed
- Fixed: Incompatibility between Form Resume and query strings
- Fixed: Update module
- Fixed: Form Widget: Default Values


01.06.2019 - ver 1.6.9

- Added: Format Text tool with conditional rules
- Added: Copy Field feature to Form Builder
- Added: Populating a Field via a Query strings
- Added: Demo file to integrate Date fields with Air Datepicker
- Added: Allow other modules/add-ons change the form responses
- Added: Default web.config file for IIS
- Added: Database Migration component
- Added: Leaflet Map to show the User's Geolocation
- Updated: Input Border color
- Updated: Message translation
- Updated: Copyright comment
- Fixed: Adds App's domain as an authorized url
- Fixed: RSVP demo form with Leaflet Map


12.02.2019 - ver 1.6.8

- Added: Form Name based on Form Title
- Added: Field "Alias" in Conditional Rules
- Added: Demo file with jQuery Mask Plugin
- Added: Display "Alias" to labelless fields
- Improved: Add-On Manager to uninstall add-ons with multiple migration
- Improved: WebHooks Add-On: Adds 'application/json' header when POST data is in json format.
- Fixed: RuleEngine compatibility with PHP 7.2
- Fixed: Error validation messages (i18n)
- Fixed: WebHook without "Save to DB" option
- Fixed: Display Email Field without a Label in Confirmation Settings
- Fixed: Form Manager. Dropdown menu broken on small screens


11.11.2018 - ver 1.6.7

- Added: Administrators can assign a form to a different user
- Added: Custom checkbox and radio button 
- Added: Form Submissions: Mark as read / unread
- Added: Demo js file to change a File field label when a file is selected
- Updated: Vendors and composer.json file
- Fixed: Validation error messages with foreign languages
- Fixed: Number of forms on dashboard (for non-admin users)
- Fixed: Https issue with cloudflare when it's needed 
- Fixed: Form Builder: Select List. Options with wrong format
- Fixed: Form Builder: "Warning! preg_replace(): Unknown modifier 'P'"
- Fixed: Dashboard queries with PHP 7.2
- Fixed: FormDOM helper detects <script> tags
- Fixed: Export Form Submissions. Excludes null data
- Fixed: Installation process. Check if popen() function exists


05.09.2018 - ver 1.6.6

- Added: Dutch translation
- Added: Format number in other languages script
- Added: jQuery UI DatePicker demo in Dutch language
- Added: Form Builder: 'Alias' option to form fields
- Added: Tool to update Form Builder fields
- Added: WebHook Add-On v1.1: Set same WebHook to multiple forms
- Added: Send WebHook notifications using 'Alias' instead of field name
- Updated: Rule Builder with better interactions
- Fixed: i18n of error message when trying to change the username
- Fixed: DateRange widget with translations
- Fixed: Avatar field
- Fixed: Link to register page (in small screens)
- Fixed: reCaptcha component (Compact size)
- Fixed: Display reCaptcha in small frame.
- Fixed: Drag last component in Form Builder
- Fixed: Conditional validation when a checkbox is checked
- Fixed: Displays progress bar when form has multiple file fields
- Fixed: Small Issue displaying Form Stats.
- Fixed: Unexpected 'class' (T_CLASS) with PHP 5.4
- Fixed: Prevent load of "en-us" locale file for moment.js


13.06.2018 - ver 1.6.5

- Fixed: Pop-Up Form Designer's translations.
- Fixed: DateRangePicker translations in the Submission Manager.


08.06.2018 - ver 1.6.4

- Added: Copy Multiple Fields by using Conditional Rules
- Added: Sender Information on the exported CSV / Excel file
- Added: Intl-Tel-Input.js with User's Country Lookup (ipinfo.io)
- Added: Auto Submit when a Radio Button is selected
- Added: Multiple emails (separated by commas) on Notification Settings
- Updated: CSRF validation on forms by default
- Updated: English as default language when a new user registers
- Updated: Vendors and composer.json file
- Fixed: Date format when form language is Arabic
- Fixed: Select List field on Form Builder
- Fixed: English to French translation
- Fixed: Duplicate records when calculating daily statistics
- Fixed: Date filter ('Today') when exporting form submissions
- Fixed: Edit Form Submission when form has a token. Eg. {{{STRIPE}}
- Fixed: Setup. Catch Guzzle Exception to detect non-friendly urls.
- Fixed: Implements DateRangePicker's i18n in the Submission Manager.


05.12.2017 - ver 1.6.3

- Added: Adds Referrer Information to Email Notifications, WebHooks and more.


03.12.2017 - ver 1.6.2

- Fixed: Migration files


02.12.2017 - ver 1.6.1

- Fixed: Logout link (New AccessControl logic)


29.11.2017 - ver 1.6

- Added: Export Form Submissions as MS Excel
- Added: Filter Form Submissions by Date Range
- Improved: Vendors (PHP v7.2 compatibility)
- Improved: jQuery UI Datepicker compatibility with conditional rules
- Fixed: Form Widget compatibility with IE11
- Fixed: Translate some missing strings
- Fixed: RTL format in Forms.
- Fixed: RTL format in alerts and breadcrumbs


08.10.2017 - ver 1.5.5

- Fixed: Form Builder (Radio Button, Checkbox, Select List)


01.10.2017 - ver 1.5.4

- Added: Translation into Portuguese language
- Changed: New .htaccess file for a better compatibility with shared hostings


24.09.2017 - ver 1.5.3

- Fixed: Step redirection. Modules: Setup, Update and Addons


23.09.2017 - ver 1.5.2

- Fixed: Guzzle 5.3.1 and PHP 7.1 compatibility. @app/vendor
- Fixed: WYSIWYG Editor and Field variables. @app/helpers/Html.php
- Fixed: PopUp Form: ScrollToTop after Submit. @app/static_files/js/form.widget.js
- Fixed: Domain communication on mobile devices. @app/static_files/js/form.widget.js


13.09.2017 - ver 1.5.1

- Fixed: WYSIWYG Editor. File Updated: @app/helpers/Html.php


01.09.2017 - ver 1.5

- Added: Pop-Up Designer
- Added: Export CSV file with Date Range
- Added: New Wysiwyg editor: summernote (Tables, videos and more)
- Added: Store images in email notifications and confirmations
- Added: Purchase Code activation in the install script
- Added: Option to enable the async email notifications in the params.php file
- Added: Javascript file to show how to use bootstrap-slider.js
- Improved: Add tables and images in email messages
- Improved: IP address client detection
- Improved: Performance page displays command to run the cron
- Improved: SMTP settings. Password field must be re-entered before updating
- Improved: Install script alerts if there isn't internet connection
- Improved: If @app/easy_forms.sql exists, install script alerts to remove it
- Improved: Install DB by using the @app/easy_forms.sql file first
- Improved: Change cron job command to run web cron by default
- Improved: Install script alerts if the PHP CLI version is invalid
- Improved: Use 'php' instead 'stmp' by default configuration to send emails
- Fixed: UTF-8 compatibility in Form Submissions on Polish language
- Fixed: Translate some missing strings
- Fixed: Click on the 'Search' button on the User Manager
- Fixed: Email notification without Reply-To
- Removed: Button to run the cron via UI
- Removed: Indonesian language
- Removed: Trumbowyg editor
- Removed: OLD and Unused js files


19.06.2017 - ver 1.4.2

- Added: Embed a Pop-Up Form
- Added: Compress uploaded images by the forms
- Added: New language: Turkish
- Improved: Vendors updated
- Improved: Apache configuration to prevent X-Frame-Options issue
- Improved: Rule Engine: Copy HTML content from one HTML element to another
- Improved: Reduces the time to resize the form when the window is resized
- Fixed: Form Builder access restriction
- Fixed: URL validation in Confirmation Settings


01.04.2017 - ver 1.4.1

- Added: Restrict access to the Login page by IP addresses
- Added: Administrators can assign Themes to another users
- Added: Field Variables in the Redirection URL
- Added: Remove javascript code in the HTML generated by the Form Builder
- Improved: Hide empty fields in the email notifications and confirmations
- Improved: Access to Forms and Themes by advanced users
- Improved:
- Fixed: Conditional validation with double css class
- Fixed: Email notifications in text plain
- Fixed: Email notifications without no-reply email address
- Fixed: Translate Password Protected Form label
- Fixed: Form Validation with two select lists
- Fixed: Form Builder access by an Advanced User
- Fixed: Multi Step forms with pages without any field
- Fixed: Html tags in a Hidden Field (Form Builder)
- Fixed: Form Widget (postMessage) in some versions of IE


28.01.2017 - ver 1.4

- Added: Duplicate Forms
- Added: Duplicate Conditional Rules
- Added: Show / Hide empty fields on Submission Details
- Improved: reCaptcha validation message
- Improved: Detect when a field is visible using a Container CSS class to validate it
- Fixed: Limit the number of words on Hide/Show columns (Submission Details)
- Fixed: Refresh comments in Submission Details
- Fixed: Double quotes on Hidden Fields (Form Builder)
- Fixed: Update referrer when the form is displayed in the same domain


16.11.2016 - ver 1.3.9

- Added: Javascript file to load jQuery DatePicker, ComboDate and Int-Tel-Input
- Added: Comment System to the Submission Manager
- Improved: Conditional rules are updated when the Form is updated by using the Form Builder.
- Improved: Submission Manager can search for non-Latin characters (Korean, Chinese and others).
- Improved: Changes the algorithm to skip between the pages on a multi-step form by using conditional rules
- Improved: Shows a confirmation message when pressing the Delete button in the Form Builder
- Fixed: An array is turned to string before validating it on the server.
- Fixed: Submission Manager Design
- Fixed: Validates a required field on the current page to skip to another by using conditional rules


17.09.2016 - ver 1.3.8

- Added: PHP Rule Engine
- Added: Conditional Validation when a field is hidden
- Improved: Export CSV file now includes uploaded files
- Improved: Conditional Rules in a Multi-Step Form
- Fixed: Remove unused tokens in custom messages
- Fixed: CSS no-padding-left and no-padding-right
- Fixed: File names uploaded with mobile devices
- Fixed: Step 5 of Installer
- Fixed: Single quotes into titles (Form Builder)
- Fixed: Form Builder save labels with Chinese characters
- Fixed: Delete Submission with a Basic User account
- Fixed: Edit Submission with a single quote in a select list


15.08.2016 - ver 1.3.7

- Added: Demo folder with javascript widgets
- Added: MetaTag Generator
- Added: SlugHelper
- Added: Rule Builder. Use Drag and Drop to change rule position.
- Improved: Installer detects PHP CLI version
- Improved: Vendors updated
- Improved: Form Embed now support autoadvance feature
- Improved: Custom SluggableBehavior
- Improved: Mail Queue
- Improved: Rule Builder Notification
- Improved: Submission Manager displays alert when a file is uploading
- Fixed: Empty Snippet
- Fixed: reCaptcha Field Position
- Fixed: Star Rating demo
- Fixed: Report Builder in PHP 7
- Fixed: Form Builder (array_key_exists)
- Fixed: Cron status code (200)
- Fixed: Submission Copy in Email Confirmation


07.07.2016 - ver 1.3.6

- Added: File Management in the Submission Manager
- Added: Restrict Websites where you can embed forms
- Added: Opposite actions on Rule Builder
- Added: WebHooks demo files
- Added: Javascript demo files
- Added: primaryKey() method on Models
- Improved: Form Builder D&D on touch screen
- Improved: Select multiple email fields in order to send email confirmations
- Improved: Customize sender name on email confirmation
- Improved: WebHooks data
- Improved: Cron via web
- Improved: Required checkbox validation
- Fixed: First column CSV export 
- Fixed: Submission Manager access
- Fixed: Labels on Email notifications
- Fixed: PHP tag on Form Builder
- Fixed: MySQL commands with table prefix
- Fixed: "options is not defined" on disabled forms


28.05.2016 - ver 1.3.5

- Added: Attach files to confirmation emails
- Added: Customize email subject with form submission data
- Added: Wysiwyg Editor to edit email text
- Added: Translation into Italian and Thai languages
- Added: Delete button to delete a field in the Form Builder
- Added: Google Place demo in a field
- Added: Combo Date demo
- Added: Start Rating demo
- Added: Implements RTL or LTR direction depending on the selected language
- Added: Export Form Submissions as CSV file via command line
- Improved: Conditional Rules can analyze multiple values separated by "|"
- Improved: Expands number of allowed tags in the email message body
- Improved: Advanced users can use templates created by admin
- Improved: Advanced users can manage their own templates
- Improved: Form Widget allows to add pixels to calculate the page OffsetTop
- Improved: Cron in Windows Environment
- Improved: Data structure for storing Form Submissions
- Improved: Rules Engine detects when a user presses "X" in IE
- Fixed: Console Component in Windows Server
- Fixed: Edit Form Submissions with unique fields
- Fixed: Form Tracker when friendly urls have been disabled
- Fixed: Date Field translation in the Form Builder
- Fixed: Click event in the Form Builder fields
- Fixed: Advanced users can save conditional rules
- Fixed: MySQL query in Dashboard
- Fixed: Previous step in a form without titles
- Fixed: "Select List" is opened twice with when the Form has conditional rules


20.04.2016 - ver 1.3.4

- Added: Delete Stats
- Added: Enable / Disable jQuery elements with conditional rules
- Added: New language: French
- Added: Implements Relation Trait behavior to handle master-detail relationships
- Added: FormEvent notifies the system when a form has been updated
- Added: Validation SMTP when configuring Mail Server
- Removed: Remove file validation on Submission Manager
- Improved: Load Google Maps JS file without protocol (schema)
- Improved: Check if the environment is Windows before running console commands
- Improved: Compatible validation patterns between client and server
- Improved: Modifies DateTime-Local field validation
- Improved: More than 20 conditional rules per page
- Improved: Reduces required width to display a form with horizontal layout
- Improved: DatePicker demo with Months and Years selector
- Improved: Allows configuring Mail Server with an API's access
- Improved: Scroll after performing an action on a form
- Improved: Reduces Form padding when displaying on smartphones
- Improved: Thank You message with variables
- Improved: Submission Manager doesn't show disabled field columns.
- Improved: Form Embed can detect when the answer came from an add-on
- Fixed: Press Enter key in a MultiStep Form
- Fixed: Field validation without label
- Fixed: Disabled fields aren't required by the server.
- Fixed: Form auto resizing protected by password.
- Fixed: Form embed code without box
- Fixed: Previous button in MultiStep Form
- Fixed: User registration validation with Captcha
- Fixed: Upload any kind of file (No validation)
- Fixed: Submission Manager: Access to upload files.
- Fixed: BulkActions in other language: Javascript alert with double quotes.
- Fixed: Check that the Select List options have text.
- Fixed: MultiStep Form creation with IE
- Fixed: Load Form Submission when accessed directly from an external link.
- Fixed: Displays notification message with several values per field


06.03.2016 - ver 1.3.3

- Added: Environment definition in console
- Added: Buttons' Support in conditional rules
- Added: New languages: German, Simplified Chinese and Traditional Chinese
- Added: CRON tool via web
- Added: Repeat Password before to change it
- Added: New oOperators to Hidden field in Rule Builder
- Removed: DB file alert message
- Improved: Responsive design with better resizing
- Improved: Cron message when installation process finished
- Improved: Confirmation / Notification messages with variables
- Improved: Form Submission Notification as plain text
- Fixed: Submission Manager is empty on Windows Server
- Fixed: Geo location. IP is not in the database
- Fixed: IE9 and IE10 form resizing
- Fixed: Edit Form Submission as Basic User
- Fixed: Unserialize() error on notifications
- Fixed: Submission Manager with hidden fields
- Fixed: Label of Hidden fields in Rule Builder


05.02.2016 - ver 1.3.2

- Added: Save a form as template
- Added: Select a different PHP version to run Cron Jobs
- Improved: Modules installer: Setup, Update and Addons
- Improved: Console component
- Improved: Download files from the Submission Manager
- Improved: Display multiple forms in the same page
- Improved: Form Builder detects when a field is deleted and shows an alert
- Improved: Filters (OFF state)
- Fixed: Export CSV File
- Fixed: Multi-Step Form with Progress Bar without titles


30.01.2016 - ver 1.3.1

- Added: Console component
- Deprecated: ConsoleHelper
- Improved: Setup / Update modules
- Improved: Cron
- Improved: Tel field validation message
- Fixed: Dashboard for advanced users
- Fixed: Performance tool
- Fixed: Required fields without labels
- Fixed: Actions buttons for advanced users
- Fixed: Google Analytics add-on event handler


25.01.2016 - ver 1.3

- Added: User registration page
- Added: Login page without password
- Added: Enable / Disable user registration from Site Settings
- Added: Add captcha to user registration from Site Settings
- Added: Set a default user rol from Site Settings
- Added: New user role: 'Advanced User' and 'User' now is 'Basic User'
- Added: Display Form Manager 'Actions' button to all users
- Added: Refresh cache tool
- Added: HTTP and HTTPS protocols supported
- Added: Print form submission
- Added: Format Number action on Form Rules
- Added: Indonesian translation
- Improved: Grid Views footer design
- Improved: Check user permissions
- Improved: Change login page when 'anyone can register' is enabled
- Improved: Addons module can update each addon version
- Improved: Install Process, update and uninstall addons
- Improved: Addons module events
- Improved: User module updated to new version
- Improved: Upload File validation on Multi Step forms
- Improved: Multi-Step forms pager
- Improved: Button component now supports 'button' input type
- Improved: Form Builder. Add images or icons to checkboxes or radio buttons
- Improved: Form Builder. Add icons to buttons
- Improved: Form Builder. New button input type: 'button'
- Fixed: Setup module error message
- Fixed: Export CSV file with 'file' fields
- Fixed: Reset password email
- Fixed: Delete multiple themes
- Fixed: Delete multiple templates
- Fixed: Default local IP for testing
- Fixed: XSS vulnerability on Submission Manager


14.01.2016 - ver 1.2

- Added: Pre-fill Form Widget with default values
- Added: Password Protected Forms
- Added: Filters in Form Manager, Templates and Themes
- Added: Rules Engine. If the condition is not met, the skip to step will be reset
- Improved: Form Builder with duplicated fields detector
- Improved: Form Settings design
- Improved: New migrations
- Improved: Spanish language translation
- Improved: Vendors updated
- Improved: Submission Event Handler with multiple cc and multiple bcc
- Fixed: Email notifications with array value
- Fixed: Resize Form Widget on IE
- Fixed: ThemeSearch table prefix
- Fixed: UserSearch profile attribute
- Fixed: Validate the field type only if input has a value
- Fixed: Form Builder without mod_rewrite
- Fixed: Delete Multiple Action on Form Manager
- Fixed: Form Builder's checkbox and radio button edition on Firefox
- Fixed: Form Builder's checkbox and radio button edition on Firefox
- Fixed: Dashboard Labels on Firefox


07.01.2016 - ver 1.1

- Added: Webhooks Add-on
- Added: Forms with Friendly Urls
- Added: Update Module
- Added: Now Easy Forms works without mod_rewrite
- Added: 'record' param to Form Widget
- Added: Cron jobs configuration with params
- Added: Email delivery with PHP mail() function
- Improved: Glyphicons version 1.9.2
- Improved: Run migrations on background
- Improved: Redirection and messaging after form submission
- Improved: In-App Analytics configurations
- Improved: Dashboard dates
- Improved: Add icon to Rule Builder error message
- Improved: Add icon to Report Builder success message
- Improved: Spanish translation
- Improved: Button custom text on multi-step forms
- Fixed: Show / hide columns on Submission Manager
- Fixed: Form Manager with table prefix
- Fixed: Submission event handler
- Fixed: Log out link
- Fixed: Export submissions as CSV file

29.12.2015 - Initial release