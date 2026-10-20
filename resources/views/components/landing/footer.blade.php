@props(['s'])
  <footer style="border-top: 1px solid #1A2026">
    <div style="width: 100%; max-width: 1200px; margin: 0 auto; box-sizing: border-box; padding: 28px 24px; display: flex; flex-wrap: wrap; gap: 12px; justify-content: space-between; align-items: center; font-size: 14px; color: #8E99A4">
      <span style="font-weight: 800; letter-spacing: -0.03em; color: #F1F4F6">code<span style="color: #1FBFA9; font-weight: 500">&lt;</span>mida<span style="color: #1FBFA9; font-weight: 500">&gt;</span></span>
      <span>{{ $s->footer_text }}</span>
    </div>
  </footer>
