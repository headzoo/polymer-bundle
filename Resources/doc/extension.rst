Functions and Filters
=====================

This list covers the functions and filters which are exported by the bundle.

polymer_asset
-------------

.. sourcecode:: twig

	polymer_asset(<asset_name>)
	
Returns the full URL to the given asset.

Example:
^^^^^^^^

.. sourcecode:: twig

	<link rel="import" href="{{ polymer_asset("hello-world.html") }}">
	
