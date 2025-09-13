<?php
require_once __DIR__ . '/lib/util.php';
require_once __DIR__ . '/lib/db.php';
require_once __DIR__ . '/secrets.php';
require_once __DIR__ . '/lib/ai.php';

try {
	$useAI = isset( $_POST['use_ai'] );
	$form  = $_POST;
	// Default colors if empty
	$form['primary']   = normalize_hex( $form['primary'] ?? '#0d6efd' );
	$form['secondary'] = normalize_hex( $form['secondary'] ?? '#6610f2' );

	if ( $useAI && defined( 'OPENAI_API_KEY' ) ) {
		$json = call_openai( $form );
	} elseif ( $useAI && defined( 'HF_API_KEY' ) ) {
		$json = call_huggingface( $form );
	} else {
		// Fallback: basic rule-based content (no API)
		$json = [
			"title"    => ucfirst( $form['site_type'] ) . " Starter",
			"nav"      => [ "Home", "About", "Contact" ],
			"palette"  => [
				"primary"    => $form['primary'],
				"secondary"  => $form['secondary'],
				"background" => "#ffffff",
				"text"       => "#212529"
			],
			"sections" => array_map( function ( $s ) {
				if ( $s === 'hero' ) {
					return [ "id"         => "hero",
					         "type"       => "hero",
					         "heading"    => "Welcome!",
					         "paragraphs" => [ "A clean start." ],
					         "cta_text"   => "Learn more",
					         "cta_link"   => "#about"
					];
				}
				if ( $s === 'about' ) {
					return [ "id"         => "about",
					         "type"       => "about",
					         "heading"    => "About us",
					         "paragraphs" => [ "We do great things." ]
					];
				}
				if ( $s === 'features' ) {
					return [ "id"      => "features",
					         "type"    => "features",
					         "heading" => "What we offer",
					         "items"   => [ "Fast", "Simple", "Responsive" ]
					];
				}
				if ( $s === 'gallery' ) {
					return [ "id"      => "gallery",
					         "type"    => "gallery",
					         "heading" => "Gallery",
					         "items"   => [ "/img/1.jpg", "/img/2.jpg", "/img/3.jpg" ]
					];
				}
				if ( $s === 'contact' ) {
					return [ "id"         => "contact",
					         "type"       => "contact",
					         "heading"    => "Contact",
					         "paragraphs" => [ "Say hi!" ],
					         "form"       => true
					];
				}

				return [ "id" => $s, "type" => $s, "heading" => ucfirst( $s ), "paragraphs" => [ "..." ] ];
			}, $form['sections'] ?? [ 'hero', 'about', 'contact' ] )
		];
	}

	// Render HTML+CSS from JSON:
	$palette   = $json['palette'] ?? [];
	$primary   = normalize_hex( $palette['primary'] ?? $form['primary'] );
	$secondary = normalize_hex( $palette['secondary'] ?? $form['secondary'] );
	$bg        = $palette['background'] ?? '#ffffff';
	$text      = $palette['text'] ?? '#212529';

	ob_start();
	include __DIR__ . '/lib/render_template.php';
	$html = ob_get_clean();

	// minimal CSS overrides using CSS variables for some components
	$css = ":root{--bs-body-bg: {$bg}; --bs-body-color: {$text};}
.navbar, .btn-primary { background-color: {$primary}!important; border-color: {$primary}!important; }
a { color: {$secondary}; }";

	// save to DB
	$pdo  = db();
	$stmt = $pdo->prepare( "INSERT INTO templates (prompt,json,html,css) VALUES (?,?,?,?)" );
	$stmt->execute( [ json_encode( $_POST ), json_encode( $json ), $html, $css ] );
	$id = $pdo->lastInsertId();

	// show preview
	echo '<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Preview</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <style>' . $css . '</style>
  </head>
  <body class="bg-body-tertiary">';
	echo "<div class='container py-3 d-flex gap-2'>
          <a class='btn btn-outline-secondary' href='index.php'>&larr; Back</a>
          <a class='btn btn-success' href='view.php?id=$id'>Save & View</a>
          <a class='btn btn-outline-primary' href='export.php?id=$id'>Download .zip</a>
        </div>";
	echo $html;
	echo '<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
  </body>
</html>';
} catch ( Throwable $e ) {
	http_response_code( 500 );
	echo "<pre>Error: " . e( $e->getMessage() ) . "</pre>";
}
