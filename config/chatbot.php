<?php

/*
|--------------------------------------------------------------------------
| Website chatbot
|--------------------------------------------------------------------------
| Without an API key the assistant answers from the site's own content
| (services, FAQ, contact details) with keyword matching. Add an Anthropic
| API key to let Claude write the answers -- still grounded in the same
| site content, and falling back to the keyword answers on any error.
*/

return [

    'enabled' => (bool) env('CHATBOT_ENABLED', true),

    // Leave empty to run in keyword mode (no external calls, no cost)
    'api_key' => env('ANTHROPIC_API_KEY'),

    'model'  => env('CHATBOT_MODEL', 'claude-opus-5-5'),

    // Chat replies are short and conversational -- low effort keeps them fast
    'effort' => env('CHATBOT_EFFORT', 'low'),

    'max_tokens' => 4000,

    // Conversation sent back to the model on each turn
    'history_turns' => 12,
    'max_message_chars' => 1000,

    'assistant_name' => 'Leamsoft Assistant',
];
