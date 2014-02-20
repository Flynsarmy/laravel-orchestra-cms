## Orchestra CMS


### A simple and intuitive CMS for Orchestra Platform

Orchestra CMS makes developing websites a breeze by providing a simple and
intuitive interface for administrators to build their pages. Orchestra CMS
completely removes the need to mess with PHP files or the command line
directly.


### Installation

1. Install [Orchestra Platform][1] version `2.1.x`
1. Add the following to composer.json:

        "repositories": [
            {
                "type": "vcs",
                "url": "https://github.com/Flynsarmy/laravel-orchestra-cms"
            }
        ],
        "require": {
            "flynsarmy/orchestra-cms": "dev-master"
        }
   and do a `composer update`
1. Open `/app/routes.php` and delete the default route:

        Route::get('/', function()
        {
    	    return View::make('hello');
        });

1. Run `php artisan asset:publish flynsarmy/orchestra-cms`
1. In the admin go to Extensions and activate Orchestra CMS.

Orchestra CMS is now installed and activated! You can access it by going to
Resources - Orchestra CMS in your Orchestra Platform Admin.



### Getting Started with Orchestra CMS

Orchestra CMS comes with three content types by default - Template, Page and Partial.

* Templates are the HTML wrappers around your Pages.
* Pages contain the content your site's visitors care most about. You can add a title and content amongst other things.
* Partials are reusable snippets of code that can be embedded into Pages or Templates.

#### Creating an Example Site

Go to Templates and click the Add button at the top right. Example HTML content will be filled in for you by default. Set a title of `Main` and hit Save.

Go to Pages and click the Add button at the top right. Give the page a title of `Home`, a slug of `/` and in the content field enter `Hello, world!` then hit Save.

You're done! Load your new site by going to `/` your sites root URL and you should be greeted with `Hello, world!`

#### Using Partials

Partials are super handy reusable snippets of code. As an example let's add a footer to our new site. Create a new partial called with title `Footer` and the following content:

    <ul>
        <li><a href="/">My Site</a></li>
        <li><a href="/another-page">Another Page</a></li>
    </ul>

Now back in your template add the following just before `</body>` add `@partial('Footer')`. Load your website again and your pages should now all have a footer.


### License

Orchestra CMS is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)


  [1]: http://orchestraplatform.com/docs/latest/installation