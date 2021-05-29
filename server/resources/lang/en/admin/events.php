<?php

return [
    // Admin events index page
    'index.title' => 'Events - Admin',
    'index.breadcrumb' => 'Events',
    'index.header' => 'All events',
    'index.query_placeholder' => 'Search for events...',
    'index.search_button' => 'Search',
    'index.start' => 'Start date:',
    'index.start_empty' => 'No start date',
    'index.end' => 'End date:',
    'index.end_empty' => 'No end date',
    'index.connected' => 'Connected path:',
    'index.connected_true' => 'true',
    'index.connected_false' => 'false',
    'index.empty' => 'No events found',
    'index.create_button' => 'Create new event',

    // Admin events create page
    'create.title' => 'Create - Events - Admin',
    'create.breadcrumb' => 'Create',
    'create.header' => 'Create new event',
    'create.name' => 'Name',
    'create.start' => 'Start date',
    'create.end' => 'End date',
    'create.connected' => 'Connected path',
    'create.connected_true' => 'True',
    'create.connected_false' => 'False',
    'create.create_button' => 'Create new event',

    // Admin events show page
    'show.title' => ':event.name - Events - Admin',
    'show.date_info' => 'Date information',
    'show.start' => 'Start date:',
    'show.start_empty' => 'No start date',
    'show.end' => 'End date:',
    'show.end_empty' => 'No end date',
    'show.path_info' => 'Path information',
    'show.connected' => 'Connected path:',
    'show.connected_true' => 'true',
    'show.connected_false' => 'false',
    'show.edit_button' => 'Edit',
    'show.delete_button' => 'Delete',

    'show.map' => 'Event map',
    'show.map_add_point_button' => 'Add point',
    'show.map_add_finish_button' => 'Add finish',
    'show.map_connect_button' => 'Connect points path',
    'show.map_disconnect_button' => 'Disconnect points path',
    'show.map_path_length' => 'Path length:',
    'show.map_path_length_message' => 'Path must contain at least two points to calculate length!',
    'show.map_latitude' => 'Latitude',
    'show.map_longitude' => 'Longitude',
    'show.map_delete_button' => 'Delete',

    'show.finishes' => 'Finishes',
    'show.finishes_name' => 'Finish #:finish.id',
    'show.finishes_point_a' => 'Point A:',
    'show.finishes_point_b' => 'Point B:',
    'show.finishes_edit_button' => 'Edit',
    'show.finishes_delete_button' => 'Delete',
    'show.finishes_empty' => 'No finishes found',
    'show.finishes_create_button' => 'Create a new finish',

    'show.classes' => 'Classes',
    'show.classes_edit_button' => 'Edit',
    'show.classes_delete_button' => 'Delete',
    'show.classes_empty' => 'No classes found',
    'show.classes_create_button' => 'Create new class',

    'show.classes_fleets' => 'Fleets',
    'show.classes_fleets_boats_button' => 'Show boats',
    'show.classes_fleets_edit_button' => 'Edit',
    'show.classes_fleets_delete_button' => 'Delete',
    'show.classes_fleets_empty' => 'No fleets found',
    'show.classes_fleets_create_button' => 'Create new fleet',

    // Admin events edit page
    'edit.title' => 'Edit - :event.name - Events - Admin',
    'edit.breadcrumb' => 'Edit',
    'edit.header' => 'Edit event',
    'edit.name' => 'Name',
    'edit.start' => 'Start date',
    'edit.end' => 'End date',
    'edit.edit_button' => 'Edit event',

    // ### Event finishes pages ###

    // Event finishes index page
    'finishes.index.breadcrumb' => 'Finishes',

    // Event finishes show page
    'finishes.show.breadcrumb' => 'Finish #:event_finish.id',

    // Event finishes create page
    'finishes.create.title' => 'Create - Finishes - :event.name - Events - Admin',
    'finishes.create.breadcrumb' => 'Create',
    'finishes.create.header' => 'Create event finish',
    'finishes.create.latitude_a' => 'Latitude A',
    'finishes.create.longitude_a' => 'Longitude A',
    'finishes.create.latitude_b' => 'Latitude B',
    'finishes.create.longitude_b' => 'Longitude B',
    'finishes.create.create_button' => 'Create event finish',

    // Event finishes edit page
    'finishes.edit.title' => 'Edit - Finish #:event_finish.id - Finishes - :event.name - Events - Admin',
    'finishes.edit.breadcrumb' => 'Edit',
    'finishes.edit.header' => 'Edit event finish',
    'finishes.edit.latitude_a' => 'Latitude A',
    'finishes.edit.longitude_a' => 'Longitude A',
    'finishes.edit.latitude_b' => 'Latitude B',
    'finishes.edit.longitude_b' => 'Longitude B',
    'finishes.edit.edit_button' => 'Edit event finish',

    // ### Event classes pages ###

    // Event classes index page
    'classes.index.breadcrumb' => 'Classes',

    // Event classes create page
    'classes.create.title' => 'Create - Classes - :event.name - Events - Admin',
    'classes.create.breadcrumb' => 'Create',
    'classes.create.header' => 'Create class',
    'classes.create.flag' => 'Flag',
    'classes.create.flag.none' => 'None',
    'classes.create.name' => 'Name',
    'classes.create.create_button' => 'Create class',

    // Event classes edit page
    'classes.edit.title' => 'Edit - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.edit.breadcrumb' => 'Edit',
    'classes.edit.header' => 'Edit class',
    'classes.edit.flag' => 'Flag',
    'classes.edit.flag.none' => 'None',
    'classes.edit.name' => 'Name',
    'classes.edit.edit_button' => 'Edit class',

    // ### Event class fleets pages ###

    // Event class fleets index page
    'classes.fleets.index.breadcrumb' => 'Fleets',

    // Event class fleets create page
    'classes.fleets.create.title' => 'Create - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.create.breadcrumb' => 'Create',
    'classes.fleets.create.header' => 'Create fleet',
    'classes.fleets.create.name' => 'Name',
    'classes.fleets.create.create_button' => 'Create fleet',

    // Event class fleets edit page
    'classes.fleets.edit.title' => 'Edit - :event_class_fleet.name - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.edit.breadcrumb' => 'Edit',
    'classes.fleets.edit.header' => 'Edit fleet',
    'classes.fleets.edit.name' => 'Name',
    'classes.fleets.edit.edit_button' => 'Edit fleet',

    // ### Event class fleet boats pages ###

    // Event class fleet boats index page
    'classes.fleets.boats.index.title' => 'Boats - :event_class_fleet.name - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.boats.index.breadcrumb' => 'Boats',
    'classes.fleets.boats.index.header' => 'All boats in this fleet',
    'classes.fleets.boats.index.query_placeholder' => 'Search for boats...',
    'classes.fleets.boats.index.search_button' => 'Search',
    'classes.fleets.boats.index.empty' => 'No boats found in this fleet',

    'classes.fleets.boats.index.boat_started_at' => 'Start time:',
    'classes.fleets.boats.index.boat_started_at_empty' => 'No start time',
    'classes.fleets.boats.index.boat_finished_at' => 'Finish time:',
    'classes.fleets.boats.index.boat_finished_at_empty' => 'No finish time',
    'classes.fleets.boats.index.boat_edit_button' => 'Edit details',
    'classes.fleets.boats.index.boat_delete_button' => 'Remove boot',
    'classes.fleets.boats.index.boat_placeholder' => 'Select a boat...',
    'classes.fleets.boats.index.boat_add_button' => 'Add boat',

    // Event class fleet boats edit page
    'classes.fleets.boats.edit.title' => 'Edit - :boat.name - Boats - :event_class_fleet.name - Fleets - :event_class.name - Classes - :event.name - Events - Admin',
    'classes.fleets.boats.edit.breadcrumb' => 'Edit',
    'classes.fleets.boats.edit.header' => 'Edit boat details',
    'classes.fleets.boats.edit.started_at_date' => 'Start date',
    'classes.fleets.boats.edit.started_at_time' => 'Start time',
    'classes.fleets.boats.edit.finished_at_date' => 'Finish date',
    'classes.fleets.boats.edit.finished_at_time' => 'Finish time',
    'classes.fleets.boats.edit.edit_button' => 'Edit boat details'
];
