# CodeIgniter Events Library

Build extendible applications with an events system.

Version 1.0.0

* Author: [Eric Barnes](http://ericlbarnes.com/ "Eric Barnes")
* Author: [Dan Horrigan](http://dhorrigan.com/ "Dan Horrigan")

## Public Methods

### register

Registers a Callback for a given event

* $event *string*
* $callback *array*
* Example: `Events::register('test_string', array('Class_name', 'string_return'));`

### trigger

Triggers an event and returns the results.

* $event *string* - The name of the event
* $data *mixed* - Any data that is to be passed to the listener
* $return_type *string* - Either 'array', 'json', 'serialized', or 'string'
* Example: `Events::trigger('test_string', 'test', 'string');`

### has_listeners

Checks if the event has any listeners

* $event *string* - The name of the event
* return *bool*

## Usage Overview

All Events functions are static.

You can add a listener to an event with the register() function:

<pre><code>Events::register('event_name_here', array('class_name_or_object_ref', 'method_name'));</code></pre>

The second parameter of register() is an array that is callable via [call_user_func()](http://us2.php.net/manual/en/function.call-user-func.php "call_user_func").

You trigger an Event by calling the trigger() function:

<pre><code>$event_return = Events::trigger('event_name_here', $data, 'string');</code></pre>

The 3rd parameter is the type of data you wish trigger() to return.  Your options are as follows:

* 'array'
* 'json'
* 'serialized'
* 'string' (the default)

## Example Usage

Because events need to be registered before being used it is a good idea to have a system
in place to load any of these before you trigger any events.

Here is an example using a third party library to register the event.

<pre>
// Example Welcome Controller

class Welcome extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		// Load Library
		$this->load->library('events');
		// Load our class that registers an event. See class Test below.
		$this->load->add_package_path(APPPATH.'third_party/test/');
		$this->load->library('test');
	}

	public function index()
	{
		var_dump(Events::trigger('test_string', 'test', 'string'));
	}
}

// Example third_party/test/libaries/test.php

class Test {

	public function __construct()
	{
		Events::register('test_string', array($this, 'string_return'));
	}

	public function string_return()
	{
		return 'I returned a string. Cakes and Pies!';
	}
}
</pre>
