<div class="site-index">
    <p align="center">
      <img width="300" src="https://github.com/teamtimer/pakk-hook/blob/master/logo.png?raw=true">
    </p>
    <h1 align="center">Welcome to Pakk</h1>
    <p align="center">
    <i>A really simple MVC framework for WordPress</i>
    </p>
    <h2>Table of contents: </h2>
    <ul>
        <li><a href="#how-to-install">How to install</a></li>
        <li><a href="#how-to-use-pakk">How to use Pakk</a></li>
        <li><a href="#basic-lifecycle">Basic lifecycle</a></li>
        <li><a href="#creating-controllers">Creating controllers</a></li>
        <li><a href="#creating-views">Creating views</a></li>
        <li><a href="#creating-models-entities">Creating models (entities)</a></li>
    </ul>
    <h2>How to install (Automatic)</h2>
    <p>
    Follow the installation instructions <a href="https://github.com/teamtimer/pakk-hook">here</a>.
    </p>
    <hr>
    <h2> How to use Pakk </h2>
    <p> Pakk is a very simple MVC framework. It is designed to be easy to use and easy to understand. </p>
    <p> Everything is stored under <code>/src</code> in your project folder. </p>
    <h2>Basic lifecycle</h2>
    <p>
        The MVC loads with <code>add_action</code> method in <code>/wp-content/mu-plugins/pakk-hook.php</code>.<br>
        The MVC is initialized in <code>App.php</code> in `vendor/teamtimer/pakk-core/src`.<br>
        It connects Cycle ORM to the database and hooks the admin menu.<br>
    </p>
    <hr>
    <h2>Creating controllers</h2>
    <p>
        Controllers are stored under <code>/src/Controllers</code>.<br>
        Controllers are the entry point for your application. They handle the requests and return the response.<br>
        Controllers are classes that extend <code>TeamTimer\Pakk\Base\Controller</code>.<br>
        Controllers have a <code>definitions()</code> method that returns an array of definitions.<br>
        Currently <code>definitions()</code> only supports adding menu items to the admin menu.<br>
        <i>Unfortunately due to the way WordPress works, admin menu items will always be sideloaded with ugly callbacks.</i><br><br>
        Check out the <code>definitions()</code> method in <code>SiteController</code> for an example.
    </p>
    <hr>
    <h2>Creating views</h2>
    <p>
        Views are stored under <code>/src/Resources/views</code>.<br>
        Views are the templates that are used to render the response.<br>
        Views are just plain PHP files.<br>
        Views have access to all variables passed to them.<br>
        Views are rendered using the <code>render()</code> method in the controller.<br>
        Check out the <code>index()</code> method in <code>SiteController</code> for an example.
    </p>
    <hr>
    <h2>Creating models <i>(entities)</i></h2>
    <p>
        Models are stored under <code>/src/Entities</code>.<br>
        Models are the classes that represent the data in your database.<br>
        Models are classes that extend <code>TeamTimer\Pakk\Base\Entity</code>.<br>
        Models <strong>must</strong> have a <code>tableName()</code> method that returns the name of the table in the database.<br>
        Models have a <code>query()</code> method that returns a <code>Cycle\ORM\Select</code> object.<br>
        Check out the <code>User</code> model for an example.
    </p>
</div>