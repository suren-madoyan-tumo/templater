<?php
// lib/prompt.php
function build_prompt(array $form): array {
  $sections = $form['sections'] ?? [];
  $siteType = $form['site_type'] ?? 'website';
  $vibe     = $form['vibe'] ?? 'modern';
  $primary  = $form['primary'] ?: '#0d6efd';
  $secondary= $form['secondary'] ?: '#6610f2';
  $brief    = trim($form['brief'] ?? '');

  $schema = [
    'title' => 'string (3-40 chars)',
    'nav' => 'array of 3-6 short strings',
    'palette' => ['primary'=>'hex','secondary'=>'hex','background'=>'hex or keyword','text'=>'hex or keyword'],
    'sections' => 'array of section objects: hero/about/features/gallery/contact'
  ];

  $sys = "You generate short, friendly website content as VALID JSON ONLY. No markdown. Keep it concise for kids reading on phones.";

  $user = [
    "task" => "Create a JSON site blueprint for a Bootstrap landing page.",
    "site_type" => $siteType,
    "vibe" => $vibe,
    "sections" => $sections,
    "preferred_colors" => ["primary"=>$primary, "secondary"=>$secondary],
    "extra_brief" => $brief,
    "json_schema_hint" => $schema,
    "rules" => [
      "Return ONE JSON object",
      "Be cheerful and short",
      "Text must be < 20 words per paragraph",
      "No HTML tags in values"
    ]
  ];

  return [$sys, json_encode($user, JSON_UNESCAPED_SLASHES)];
}
