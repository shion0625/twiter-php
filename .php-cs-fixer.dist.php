<?php
return PhpCsFixer\Config::create()
->setUsingCache(false)
    ->setRiskyAllowed(true)
    ->setRules([
        '@PSR2' => true,
        '@PhpCsFixer' => true,
        'blank_line_after_opening_tag' => true,
        'blank_line_before_statement' => ['statements' => []],
        'braces' => ['allow_single_line_closure' => true],
        'compact_nullable_typehint' => true,
        'concat_space' => ['spacing' => 'one'],
        'declare_equal_normalize' => ['space' => 'none'],
        'function_typehint_space' => true,
        'method_argument_space' => ['on_multiline' => 'ensure_fully_multiline'],
        'multiline_whitespace_before_semicolons' => ['strategy' => 'no_multi_line'],
        'new_with_braces' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => ['break', 'case', 'continue', 'curly_brace_block', 'default', 'extra', 'parenthesis_brace_block', 'return',
            'square_brace_block', 'switch', 'throw', 'use', 'useTrait', 'use_trait'],
        'no_leading_import_slash' => true,
        'no_leading_namespace_whitespace' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_trailing_comma_in_singleline_array' => true,
        'no_unused_imports' => true,
        'no_whitespace_in_blank_line' => true,
        'return_type_declaration' => ['space_before' => 'none'],
        'single_import_per_statement' => false,
        'single_trait_insert_per_statement' => false,
        'trailing_comma_in_multiline_array' => []
    ])->setFinder(
        PhpCsFixer\Finder::create()
            ->exclude(['vendor'])
            ->in(__DIR__)
    );