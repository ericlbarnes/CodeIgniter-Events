# CodeIgniter Events Library

Build extendible applications with an events system.

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
