<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * The messages must be strings but have no real requirements
 * beyond that. By convention, I suggest the following format:
 *
 * <singular noun>.<past tense verb>[-<modifier>]
 *
 * The entire message should be entirely lower case.
 * The noun and verb should always be present.
 * Where appropriate, the verb should be one of the CRUD verbs.
 *    (create, update, destroy)
 * The modifier is entirely optional and simply used for
 * further specifying an otherwise duplicated message.
 *
 * Here are some examples:
 *
 * profile.created
 * question.created
 * answer.selected-best
 *
 * At the simplest, message handler mappings should be an array
 * made up of the CodeIgnitor load type (library, model, etc),
 * the class name and the handler method to call.
 *
 * The handler method may accept zero, one or two parameters. The event
 * system will reflect on the method and only pass the appropriate
 * number of parameters based on the method signature.
 *
 * When the method accepts one argument, it will be the object passed
 * when sending the message.
 *
 * Optionally, when setting up the handler mapping, you may provide a
 * fourth item. This fourth item will be passed as the second parameter
 * to handler methods that support it.
 *
 * Here is a basic handler mapping:
 *
 * $config['user.created'] = array(
 *   array('model', 'Notifications', 'welcome_user')
 * );
 *
 * Here is a handler supporting the fourth item:
 *
 * $config['question.created'] = array(
 *   array('model', 'Points', 'add_user_points', 20)
 * );
 *
 * This could allow for having a single method that handles multiple
 * messages with the fourth argument determining it's slightly altered
 * behavior.
 *
 */