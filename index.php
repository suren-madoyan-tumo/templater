<!doctype html>
<html lang="en" data-bs-theme="light">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Templater</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
    <link href="public/style.css" rel="stylesheet">
  </head>
  <body class="bg-body-tertiary">
    <div class="container py-4">
      <h1 class="mb-3">AI Website Template Generator</h1>
      <p class="text-secondary">Describe your site, pick sections, and generate a Bootstrap starter.</p>

      <form action="generate.php" method="post" class="row g-3">
        <div class="col-md-6">
          <label class="form-label">Site Type</label>
          <select name="site_type" class="form-select" required>
            <option value="portfolio">Portfolio</option>
            <option value="restaurant">Restaurant</option>
            <option value="shop">Small Shop</option>
            <option value="event">Event</option>
            <option value="school_club">School Club</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Vibe / Style</label>
          <select name="vibe" class="form-select">
            <option value="modern">Modern</option>
            <option value="playful">Playful</option>
            <option value="minimal">Minimal</option>
            <option value="elegant">Elegant</option>
          </select>
        </div>

        <div class="col-md-6">
          <label class="form-label">Primary Color (hex)</label>
          <input name="primary" class="form-control" placeholder="#0d6efd" />
        </div>

        <div class="col-md-6">
          <label class="form-label">Secondary Color (hex)</label>
          <input name="secondary" class="form-control" placeholder="#6610f2" />
        </div>

        <div class="col-12">
          <label class="form-label">Sections</label>
          <div class="form-check">
            <input class="form-check-input" name="sections[]" type="checkbox" value="hero" id="secHero" checked>
            <label class="form-check-label" for="secHero">Hero</label>
          </div>
          <div class="form-check"><input class="form-check-input" name="sections[]" type="checkbox" value="about" id="secAbout"><label class="form-check-label" for="secAbout">About</label></div>
          <div class="form-check"><input class="form-check-input" name="sections[]" type="checkbox" value="features" id="secFeatures"><label class="form-check-label" for="secFeatures">Features/Services</label></div>
          <div class="form-check"><input class="form-check-input" name="sections[]" type="checkbox" value="gallery" id="secGallery"><label class="form-check-label" for="secGallery">Gallery</label></div>
          <div class="form-check"><input class="form-check-input" name="sections[]" type="checkbox" value="contact" id="secContact"><label class="form-check-label" for="secContact">Contact</label></div>
        </div>

        <div class="col-12">
          <label class="form-label">Extra Brief (optional)</label>
          <textarea name="brief" class="form-control" rows="3" placeholder="E.g., Vegan cafe, cozy, 3 featured items, Instagram link..."></textarea>
        </div>

        <div class="col-12">
          <div class="form-check form-switch">
            <input class="form-check-input" name="use_ai" type="checkbox" id="useAI" checked>
            <label class="form-check-label" for="useAI">Use AI (JSON mode)</label>
          </div>
        </div>

        <div class="col-12 d-flex gap-2">
          <button class="btn btn-primary">Generate</button>
          <a href="view.php" class="btn btn-outline-secondary">View Saved Templates</a>
        </div>
      </form>
    </div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.min.js" integrity="sha384-G/EV+4j2dNv+tEPo3++6LCgdCROaejBqfUeNjuKAiuXbjrxilcCdDz6ZAVfHWe1Y" crossorigin="anonymous"></script>
  </body>
</html>
