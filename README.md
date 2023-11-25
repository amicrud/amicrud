# AmiCrud

AmiCrud is a Laravel package designed to facilitate CRUD (Create, Read, Update, Delete) operations within Laravel applications. It offers an efficient way to handle database operations with minimal setup, supporting a range of features for rapid development.

## Features

- Streamlined CRUD operations for Laravel models.
- Easy integration with existing Laravel applications.
- Customizable views for creating, reading, updating, and deleting records.
- Support for various data export formats (PDF, CSV, Excel).
- Enhanced form validation and error handling.

## Installation

You can install the package via Composer. Run the following command in your Laravel project:

```shell

composer require amicrud/amicrud

```


## Installation

After installing the package, publish the configuration and view files (it is not required):
php artisan vendor:publish --provider="AmiCrud\AmiCrud\AmiCrudServiceProvider"


## Usage

 ## Basic Usage
1. Extend the AmiCrud Class in Your Controller:
 To utilize AmiCrud, extend the AmiCrud class in your controller. This will enable CRUD functionalities for the specified model.
 
  <code> 
    use AmiCrud\AmiCrud\AmiCrudTable;

    class UserController extends AmiCrudTable {

        protected $model = User::class; // Specify your Eloquent model
    }
  </code>

  2. Define Routes:
  Define routes in your web.php that point to your controller's methods.

  <code>
     Route::resource('users', UserController::class);
  </code>


## Advanced Customization

  Custom Views: Override the default views by creating your own and referencing them in your controller.

  Form Validation: Customize form validation rules within your controller to cater to specific requirements of your application.

  Data Export: Utilize built-in methods for data export to PDF, Excel, or CSV formats.

## Contributing

Contributions to the AmiCrud package are welcome! Feel free to submit pull requests, report bugs, or suggest new features.

## Support
If you encounter any problems or have questions, please open an issue on the GitHub repository.

## License
The AmiCrud package is open-sourced software licensed under the MIT license.
