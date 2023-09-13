<?php
 /**
  * Plugin Name: Load scripts from Vite
  */

/* ensure SRI and type="module" are set */
add_filter(
    "script_loader_tag",
    function ($tag, $handle) {
        $integrity = wp_scripts()->get_data($handle, "integrity");
        $module = wp_scripts()->get_data($handle, "module");

        if ($integrity) {
            $tag = str_replace('></', ' integrity="'. esc_attr($integrity) .'"></', $tag);
        }

        if ($module) {
            $tag = str_replace("type='text/javascript'", "type='module'", $tag);
        }

        return $tag;
    },
    10,
    2
);

function vite_load_asset($handle, $entrypoint)
{
    if (getenv("VITE_SERVER")) {
        wp_enqueue_script("vite-client", getenv("VITE_SERVER") . "@vite/client", [], null);
        wp_scripts()->add_data("vite-client", "module", true);
        wp_enqueue_script($handle, getenv("VITE_SERVER") . $entrypoint, [], null);
        wp_scripts()->add_data($handle, "module", true);
    } else {
        $viteManifest = json_decode(file_get_contents(get_template_directory() . '/../dist/manifest.json'), true);
        $manifestItem = $viteManifest[$entrypoint];

        wp_enqueue_script($handle, get_template_directory_uri() . "/../dist/" . $manifestItem["file"], [], null);
        wp_scripts()->add_data($handle, "module", true);
        foreach ($manifestItem["css"] as $i => $url) {
            wp_enqueue_style($handle . '-' . $i, get_template_directory_uri() . "/../dist/" . $url, [], null);
        }
    }
}
