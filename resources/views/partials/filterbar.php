<div class="filter-bar">
  <form id="filter-form" style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; width: 100%;">
    <!-- Date Range -->
    <div class="filter-group">
      <span class="filter-label">Periode:</span>
      <input type="date" id="filter-date-from" name="date_from" class="filter-input" value="2023-01-01">
      <span style="color: var(--muted);">-</span>
      <input type="date" id="filter-date-to" name="date_to" class="filter-input" value="2026-10-31">
    </div>

    <!-- Category -->
    <div class="filter-group">
      <span class="filter-label">Kategori:</span>
      <select id="filter-category" name="category_id" class="filter-select">
        <option value="">Semua Kategori</option>
      </select>
    </div>

    <!-- Channel -->
    <div class="filter-group">
      <span class="filter-label">Channel:</span>
      <select id="filter-channel" name="channel_id" class="filter-select">
        <option value="">Semua Channel</option>
      </select>
    </div>

    <!-- Region -->
    <div class="filter-group">
      <span class="filter-label">Wilayah:</span>
      <select id="filter-region" name="region_id" class="filter-select">
        <option value="">Semua Wilayah</option>
      </select>
    </div>

    <button type="button" id="btn-reset-filters" class="btn-filter-reset">Reset Filter</button>
  </form>
</div>
