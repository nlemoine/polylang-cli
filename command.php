<?php
/**
 * CLI interface for the Polylang plugin.
 *
 * @author  Peter J. Herrel <peterherrel@gmail.com>
 * @package diggy/polylang-cli
 * @version 1.0.0-prealpha.1
 */

if ( defined( 'WP_CLI' ) && WP_CLI ) {

    if ( version_compare( PHP_VERSION, '5.5', '<' ) ) {
        return WP_CLI::error( sprintf( 'This WP-CLI package requires PHP version %s or higher.', '5.5' ) );
    }

    if ( version_compare( WP_CLI_VERSION, '1.0.0', '<' ) ) {
        return WP_CLI::error( sprintf( 'This WP-CLI package requires WP-CLI version %s or higher. Please visit %s', '1.0.0', 'https://wp-cli.org/#updating' ) );
    }

    # api, cli
    require __DIR__ . '/src/Api/Api.php';
    require __DIR__ . '/src/Api/Cli.php';

    # traits
    require __DIR__ . '/src/Traits/Cpt.php';
    require __DIR__ . '/src/Traits/SettingsErrors.php';
    require __DIR__ . '/src/Traits/Properties.php';
    require __DIR__ . '/src/Traits/Utils.php';

    # base command
    require __DIR__ . '/src/Commands/BaseCommand.php';

    # commands
    require __DIR__ . '/src/Commands/Api.php';
    require __DIR__ . '/src/Commands/Doctor.php';
    require __DIR__ . '/src/Commands/Option.php';
    require __DIR__ . '/src/Commands/Taxonomy.php';
    require __DIR__ . '/src/Commands/Flag.php';
    require __DIR__ . '/src/Commands/Post.php';
    require __DIR__ . '/src/Commands/Term.php';
    require __DIR__ . '/src/Commands/Cache.php';
    require __DIR__ . '/src/Commands/Lang.php';
    require __DIR__ . '/src/Commands/PostType.php';

    WP_CLI::add_hook( 'before_wp_load', function() {
        WP_CLI::add_wp_hook( 'init', function() {
            # make sure polylang_mo post type is always registered
            if ( ! post_type_exists( 'polylang_mo' ) ) {
                $labels = array( 'name' => __( 'Strings translations', 'polylang' ) );
                register_post_type( 'polylang_mo', array( 'labels' => $labels, 'rewrite' => false, 'query_var' => false, '_pll' => true ) );
            }
        });
    });

    // WP_CLI::add_command( 'pll',        Polylang_CLI\Cli::class );

    WP_CLI::add_command( 'pll api',       Polylang_CLI\Commands\Api::class );
    WP_CLI::add_command( 'pll cache',     Polylang_CLI\Commands\Cache::class );
    WP_CLI::add_command( 'pll doctor',    Polylang_CLI\Commands\Doctor::class );
    WP_CLI::add_command( 'pll flag',      Polylang_CLI\Commands\Flag::class );
    WP_CLI::add_command( 'pll lang',      Polylang_CLI\Commands\Lang::class );
    WP_CLI::add_command( 'pll option',    Polylang_CLI\Commands\Option::class );
    WP_CLI::add_command( 'pll post',      Polylang_CLI\Commands\Post::class );
    WP_CLI::add_command( 'pll post-type', Polylang_CLI\Commands\PostType::class );
    WP_CLI::add_command( 'pll taxonomy',  Polylang_CLI\Commands\Taxonomy::class );
    WP_CLI::add_command( 'pll term',      Polylang_CLI\Commands\Term::class );

}
