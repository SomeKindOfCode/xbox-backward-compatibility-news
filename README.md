# Xbox Backward Compatibility

This script grabs the list of Xbox 360 games that are backward compatible with the Xbox One and displays them as an optimzed website and RSS-Feeds.

## Tools used

- [Flight](http://flightphp.com)
- [Medoo](http://medoo.in)

## Setup

Clone the repository into your desired folder and point your server root directory to the `public` folder.
In the project root, run `composer install` on the command line and execute the `setup.php` to setup the core database structure.

In the default setup, this app uses *SQLite* and stores the database in the `db` folder.
To modify these settings, take a look at the [Medoo Documentation](http://medoo.in/api/new) and modify `app/bootstrap.php` as desired.

---

*by [somekindofcode.com](https://somekindofcode.com)*