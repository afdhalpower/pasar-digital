# 🎨 PublikDigital Design System & UI/UX Standards

**Stitch Project ID:** `4452864209694665210`  
**Stitch Project Name:** `PublikDigital Marketplace`  
**Master CSS File:** `resources/css/design-system.css`  

This document serves as the absolute **Visual Source of Truth** for PublikDigital. Whether you are pair-programming with **Antigravity**, **Codex**, or **Opencode**, this guide ensures that any new feature, screen, or component remains 100% pixel-perfect and visually consistent with the existing application.

---

## 🚀 1. Visual Theme & Atmosphere

PublikDigital bridges the gap between high-end editorial magazines and smooth, utilitarian digital marketplaces. The design targets independent creators, designers, and discerning buyers by utilizing a **Dual-Personality Aesthetic**:

*   **The Immersive Showcase (Dark Theme - Main Portal):** Cinematic, dark, and highly premium. The dark background lowers visual noise and elevates the premium look of digital products. It leverages **Glassmorphism**, subtle **radial glows**, and smooth **GPU-accelerated animations**.
*   **The Focused Utility (Dark/Light Responsive - Admin Panel):** Crisp, highly readable, and structured. Admin workflows in Filament v5 utilize default forced dark layouts with standard gray backgrounds, high contrast text, and Teal accents to reduce cognitive fatigue during administration.

---

## 🎨 2. Color Palette & CSS Variables

Our color design is strictly mapped to CSS Custom Properties. **Do not use ad-hoc inline hex codes or Tailwind standard colors.** Always use the following semantic variables:

| CSS Variable | Natural Language Name | Hex Value | Functional Role & Application |
| :--- | :--- | :--- | :--- |
| `--color-primary` | Stitch Teal Glow | `#6bd8cb` | Active states, hover titles, glowing focus ring accents. |
| `--color-teal-brand` | Forest Teal | `#0d9488` | Standard action buttons, primary tags, brand identifiers. |
| `--color-primary-container` | Teal Container Deep | `#29a195` | Secondary container borders and highlights. |
| `--color-on-primary` | Contrast Dark Teal | `#003732` | Text color when layered directly over `--color-primary`. |
| `--color-background` | Deep Carbon Ink | `#111415` | Default dark-theme viewport backdrop. |
| `--color-surface` | Soft Matte Obsidian | `#111415` | Baseline sheet backdrop for cards and headers. |
| `--color-surface-container` | Charcoal Container | `#1d2021` | Product card panels and list backgrounds. |
| `--color-surface-container-high` | Elevated Obsidian | `#282a2b` | Input box backdrops and active hover zones. |
| `--color-surface-container-lowest` | True Night Void | `#0c0f10` | Global footer background. |
| `--color-on-surface` | Silk White | `#e1e3e4` | Primary body copy and titles. |
| `--color-on-surface-variant` | Slate Grey | `#bcc9c6` | Secondary metadata (categories, price tags, descriptions). |
| `--color-outline-variant` | Ink Line Border | `#3d4947` | Soft divider borders and secondary button outlines. |
| `--color-success` | Vivid Emerald | `#10b981` | Positive actions, checkmarks, download confirm states. |
| `--color-warning` | Marigold Amber | `#f59e0b` | Alert warnings, pending orders, notice signs. |

---

## ✍️ 3. Typography Rules

We employ a classic, sophisticated typeface pairing from Google Fonts that blends heritage and accessibility:

1.  **Editorial Headline Font:** **Playfair Display** (Serif)
    *   *Usage:* Master display hero titles (`.display-lg`), section headers (`.headline-md`), and product card names (`.product-card-title`).
    *   *Sizing:* Hero titles use clamping (`clamp(2.5rem, 5vw, 4rem)`) for absolute mobile compatibility.
    *   *Spacing:* Large serif headers must use tight letter-spacing (`-0.02em`) to preserve an editorial vibe.
2.  **Systematic Sans Font:** **Inter** (Sans-Serif)
    *   *Usage:* Body copy (`.body-md`), input text, button labels (`.label-md`), status chips (`.label-sm`).
    *   *Sizing:* Baseline readable sizing is `1rem` (16px) for normal reading and `0.875rem` (14px) for controls.

---

## 📐 4. Geometry, Spacing & Rhythm

*   **Vertical Rhythm:** All spacing must adhere to an **8px grid unit** (mapped to `--space-1` up to `--space-15`):
    *   `--space-1`: `8px` (micro adjustments)
    *   `--space-2`: `16px` (internal margins, card paddings)
    *   `--space-3`: `24px` (outer gutters, large card paddings)
    *   `--space-4`: `32px` (component spacing)
    *   `--space-10`: `80px` / `--space-15`: `120px` (large section padding blocks)
*   **Corner Radii:** Curved boundaries must be approachably rounded without becoming bubbly:
    *   `--radius-sm`: `0.25rem` (4px) - small checkbox labels.
    *   `--radius-md`: `0.5rem` (8px) - standard input fields, search filters, and action buttons.
    *   `--radius-lg`: `1rem` (16px) - product visual cards and hero display wraps.
    *   `--radius-full`: `9999px` - pill-shaped conversion buttons and tag chips.
*   **Depth & Elevation (Shadows):**
    *   *Standard Card Depth:* `#1d2021` with a `1px` border in `#3d4947` (no heavy shadow in static dark mode).
    *   *Hover State Lift:* Elevate cards vertically by `-6px` and apply a diffused Teal glow: `0 12px 30px rgba(13, 148, 136, 0.15)`.

---

## 🧱 5. Core Components & CSS Classes

Always utilize the following pre-configured classes located in `resources/css/design-system.css` when building or changing views:

### A. Navigation
*   **Class:** `.nav-glass`
*   *Specs:* `backdrop-filter: blur(12px)`, background `rgba(17, 20, 21, 0.8)`, border-bottom `1px solid rgba(107, 216, 203, 0.1)`.
*   *JavaScript Event:* The class `.scrolled` is dynamically toggled on scroll to apply a subtle bottom shadow.

### B. Action Buttons
*   **Primary Button (`.btn-primary`):** Solid background Forest Teal (`#0d9488`). Smooth transition on hover, shifting `translateY(-1px)` and rendering a solid teal glow shadow.
*   **Secondary Button (`.btn-secondary`):** Transparent background with `1px` border in `--color-outline-variant`. On hover, border and text colors shift to primary Teal (`#6bd8cb`).
*   **Pill Modifier (`.btn-pill`):** Rounds the button completely (`--radius-full`).

### C. Cards (`.product-card`)
*   *Aesthetics:* Corner radius `1rem`, surface background `--color-surface-container`, transition `all 0.4s cubic-bezier(0.4, 0, 0.2, 1)`.
*   *Light Sweep Shimmer Effect:* Built into the `.product-card::before` pseudo-element. On hover, triggers a beautiful high-fidelity diagonal flash of light (`@keyframes shine`).
*   *Scale Effect:* Images inside cards automatically transition scale to `1.05` on hover for dynamic tactile response.

### D. Filter Tags (`.chip` & `.chip-primary`)
*   *Aesthetics:* Pill rounded, small label caps, background `rgba(107, 216, 203, 0.1)` with active state shifting background to `20% opacity` and primary Teal border.

### E. User Inputs (`.input-field`)
*   *Aesthetics:* Background `var(--color-surface-container-high)`, border transparent. On focus, transition color border to primary Teal (`#6bd8cb`) and shift background to `var(--color-surface-container-highest)`.

---

## 🛠️ 6. Filament Admin Panel Visual Alignment

Our administration dashboard uses **Filament v5** and is visually unified with the frontend aesthetic via `App\Providers\Filament\AdminPanelProvider.php`:

*   **Forced Theme:** Dark mode is hard-coded as the mandatory default (`->darkMode(true, true)`).
*   **Color Theme Mapping:**
    *   `primary` => Custom Filament Teal (seamless match with our `--color-teal-brand`).
    *   `gray` => Custom Filament Slate (seamless match with our `--color-on-surface-variant`).
    *   `danger` => Rose Color (seamless match with `--color-error`).
*   **Typography:** Filament panels use the **Inter** font family, ensuring 100% text design alignment.

---

## 📂 7. Layout Code Structures & MVC Architectural Guidelines

### A. MVC Architecture Alignment
*   **Models (`app/Models/`):** Maintain business logic and relationships (e.g. `User`, `Product`, `Order`, `OrderItem`). Use model scopes or Eloquent helper methods instead of heavy queries in controllers.
*   **Controllers (`app/Http/Controllers/`):** Keep controllers lightweight and focused. Controllers should strictly handle validation, call domain logic or models, and pass data to views (using clean compact arrays).
*   **Views (`resources/views/`):** Keep views focused strictly on visual presentation. Avoid database queries, calculations, or raw business logic inside Blade files. Use layout inheritance, includes, and reusable components.

### B. Directory Structure & Layout Mappings
*   **Main Wrapper Layout:** [layouts/marketplace.blade.php](file:///home/aqsadev/PRIBADI/republikdigital/resources/views/layouts/marketplace.blade.php) - Renders HTML5 base wrappers, Google Font links, standard meta headers, and embeds navigation and footer.
*   **Reusable Component:** [components/product-card.blade.php](file:///home/aqsadev/PRIBADI/republikdigital/resources/views/components/product-card.blade.php) - Single component to render digital product items uniformly across the homepage and search catalogs.
*   **Buyer Dashboard Views (`resources/views/buyer/`):**
    *   `dashboard.blade.php` - Summary page (overview of spendings, downloads, recent orders).
    *   `orders.blade.php` - Transaction list page with payment status badge states.
    *   `downloads.blade.php` - Purchased product catalog displaying download actions.
    *   `profile.blade.php` - Secure profile and password management settings view.
    *   `sidebar.blade.php` - Sidebar navigation component with active state mapping.
*   **Buyer Controller:** [app/Http/Controllers/Buyer/BuyerDashboardController.php](file:///home/aqsadev/PRIBADI/republikdigital/app/Http/Controllers/Buyer/BuyerDashboardController.php) - Manages data orchestration for all buyer views.

---

## 🤖 8. AI Orchestration Guide (How to Keep Consistency)

If you are continuing this project using different AI assistants (such as **Antigravity**, **Codex**, or **Opencode**), copy and paste the prompt below as the **VERY FIRST instruction** of your new session. This keeps the models locked onto the project architecture and prevents them from introducing breaking changes.

### 📋 COPY-PASTE PROMPT TEMPLATE FOR AI AGENTS:
```text
You are an elite developer working on PublikDigital, a premium digital marketplace built on Laravel 13, Filament v5, and a custom CSS design system based on Google Stitch design tokens.

Before writing or editing any code, you MUST read the following source-of-truth files to align your coding patterns:
1. READ: Root repository file `/DESIGN.md` for UI/UX guidelines.
2. READ: `/resources/css/design-system.css` to review custom color variables, button specs, micro-animations, and utility classes.
3. READ: `/app/Providers/Filament/AdminPanelProvider.php` to understand admin configuration.
4. READ: `/README.md` to review the file tree structure.

CRITICAL IMPLEMENTATION CONSTRAINTS:
- NEVER introduce external CSS libraries (e.g. TailwindCSS, Bootstrap) unless explicitly told. We use Vanilla CSS.
- NEVER write inline style parameters with hardcoded colors. Always use CSS variables, e.g. `var(--color-primary)`.
- Use pre-built utility classes like `.btn-primary`, `.btn-secondary`, `.product-card`, `.chip-primary`, and typography tags like `.display-lg`, `.headline-md`, `.body-md`.
- Keep the layout clean, spacious (8px vertical rhythm), and responsive using media queries mapped inside `design-system.css`.
- Ensure new Blade files inherit our master layout: `@extends('layouts.marketplace')`.
```

By following this guideline, your PublikDigital application will look incredibly premium, feel professional, and maintain standard aesthetics regardless of which developer or AI tools you choose to build it with!
