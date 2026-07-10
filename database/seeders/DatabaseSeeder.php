<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\LibraryEntry;
use App\Models\Testimonial;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Categories ─────────────────────────────────────────────────────
        $cats = [
            ['name'=>'Spell Kits',  'slug'=>'spell-kits',  'type'=>'shop',    'description'=>'Complete ritual spell kits for practitioners', 'icon'=>'✦'],
            ['name'=>'Grimoires',   'slug'=>'grimoires',   'type'=>'shop',    'description'=>'Digital and physical books of arcane knowledge','icon'=>'📖'],
            ['name'=>'Crystals',    'slug'=>'crystals',    'type'=>'shop',    'description'=>'Sacred crystals and gemstones imbued with energy','icon'=>'💎'],
            ['name'=>'Tarot',       'slug'=>'tarot',       'type'=>'shop',    'description'=>'Tarot decks and divination tools','icon'=>'🃏'],
            ['name'=>'Runes',       'slug'=>'runes',       'type'=>'shop',    'description'=>'Ancient runic sets and oracle stones','icon'=>'ᚱ'],
            ['name'=>'Amulets',     'slug'=>'amulets',     'type'=>'shop',    'description'=>'Protective talismans and enchanted amulets','icon'=>'🔮'],
            ['name'=>'Candles',     'slug'=>'candles',     'type'=>'shop',    'description'=>'Ritual candles and sacred flame tools','icon'=>'🕯'],
            ['name'=>'Spells',      'slug'=>'spells',      'type'=>'library', 'description'=>'A compendium of ancient spells','icon'=>'✦'],
            ['name'=>'Rituals',     'slug'=>'rituals',     'type'=>'library', 'description'=>'Sacred rituals for every occasion','icon'=>'⊕'],
            ['name'=>'Moon Phases', 'slug'=>'moon-phases', 'type'=>'library', 'description'=>'Harness the power of lunar cycles','icon'=>'☽'],
        ];
        foreach ($cats as $c) { Category::firstOrCreate(['slug'=>$c['slug']], $c); }

        $catMap = Category::pluck('id','slug');

        // ── Products ───────────────────────────────────────────────────────
        $products = [
            ['name'=>'Shadow Moon Ritual Kit','slug'=>'shadow-moon-ritual-kit','description'=>'A complete kit for shadow moon workings, including black salt, obsidian, and a hand-bound grimoire.','lore'=>'Forged in the liminal space between worlds, this kit was assembled under the dark moon by the Coven of the Eternal Flame.','price'=>49.99,'original_price'=>69.99,'type'=>'physical','category_id'=>$catMap['spell-kits'],'tags'=>['arcane','ritual','shadow'],'rating'=>4.9,'review_count'=>127,'in_stock'=>true,'featured'=>true,'is_new'=>true,'is_bestseller'=>false],
            ['name'=>'Elemental Summoning Kit','slug'=>'elemental-summoning-kit','description'=>'Invoke the four classical elements with this premium ritual kit.','lore'=>'Long have the elements answered the call of those who know the proper words.','price'=>34.99,'original_price'=>null,'type'=>'physical','category_id'=>$catMap['spell-kits'],'tags'=>['arcane','elemental'],'rating'=>4.7,'review_count'=>83,'in_stock'=>true,'featured'=>false,'is_new'=>true,'is_bestseller'=>true],
            ['name'=>'The Crimson Codex — Digital Grimoire','slug'=>'crimson-codex-digital','description'=>'A 300-page digital grimoire covering spells, rituals, and mystical herbalism.','lore'=>'Written by Arcane Sanctum scholars over three decades, the Crimson Codex is the definitive modern grimoire.','price'=>19.99,'original_price'=>29.99,'type'=>'digital','category_id'=>$catMap['grimoires'],'tags'=>['grimoire','digital'],'rating'=>4.8,'review_count'=>241,'in_stock'=>true,'featured'=>false,'is_new'=>false,'is_bestseller'=>true],
            ['name'=>'Necronomicon Replica — Limited Edition','slug'=>'necronomicon-replica','description'=>'A beautifully bound limited-edition replica of the forbidden tome.','lore'=>'Every crack of the leather spine, every aged page — this is as close as mortals dare come to the original.','price'=>89.99,'original_price'=>null,'type'=>'physical','category_id'=>$catMap['grimoires'],'tags'=>['grimoire','limited'],'rating'=>5.0,'review_count'=>19,'in_stock'=>true,'featured'=>true,'is_new'=>false,'is_bestseller'=>false],
            ['name'=>'Obsidian Sphere Collection','slug'=>'obsidian-sphere-collection','description'=>'Three hand-polished obsidian spheres in graduating sizes, perfect for scrying.','lore'=>'Obsidian holds the memory of volcanic fire. These spheres were formed in the heart of ancient calderas.','price'=>44.99,'original_price'=>null,'type'=>'physical','category_id'=>$catMap['crystals'],'tags'=>['crystal','obsidian'],'rating'=>4.6,'review_count'=>56,'in_stock'=>true,'featured'=>true,'is_new'=>false,'is_bestseller'=>true],
            ['name'=>'Amethyst Cluster — Raw Grade A','slug'=>'amethyst-cluster-raw','description'=>'A stunning raw amethyst cluster for altar work, meditation, and dream magic.','lore'=>'Amethyst has guarded sleepers against the dark since the dawn of civilization.','price'=>29.99,'original_price'=>39.99,'type'=>'physical','category_id'=>$catMap['crystals'],'tags'=>['crystal','amethyst'],'rating'=>4.8,'review_count'=>93,'in_stock'=>true,'featured'=>false,'is_new'=>true,'is_bestseller'=>false],
            ['name'=>'The Arcane Tarot Deck — Gold Edition','slug'=>'arcane-tarot-gold-edition','description'=>'78-card tarot deck with gold foil edges and a velvet pouch, exclusive to Arcane Sanctum.','lore'=>'Illustrated by master occult artist Vael the Grey, each card is a portal.','price'=>59.99,'original_price'=>79.99,'type'=>'physical','category_id'=>$catMap['tarot'],'tags'=>['tarot','gold'],'rating'=>4.9,'review_count'=>312,'in_stock'=>true,'featured'=>true,'is_new'=>true,'is_bestseller'=>false],
            ['name'=>'Digital Tarot Guidebook — PDF','slug'=>'digital-tarot-guidebook','description'=>'Comprehensive 150-page PDF guide to reading the Major and Minor Arcana.','lore'=>'An essential companion for any tarot practitioner, from novice to adept.','price'=>9.99,'original_price'=>14.99,'type'=>'digital','category_id'=>$catMap['tarot'],'tags'=>['tarot','guide'],'rating'=>4.5,'review_count'=>178,'in_stock'=>true,'featured'=>false,'is_new'=>false,'is_bestseller'=>true],
            ['name'=>'Elder Futhark Rune Set — Black Onyx','slug'=>'elder-futhark-rune-set-onyx','description'=>'24 hand-carved black onyx runes with a leather casting cloth and guidebook.','lore'=>'Carved under a waxing moon, these onyx runes carry the weight of ancestral memory.','price'=>74.99,'original_price'=>null,'type'=>'physical','category_id'=>$catMap['runes'],'tags'=>['runes','norse'],'rating'=>4.9,'review_count'=>67,'in_stock'=>true,'featured'=>true,'is_new'=>true,'is_bestseller'=>false],
            ['name'=>'Seal of Solomon Amulet — Sterling Silver','slug'=>'seal-of-solomon-amulet','description'=>'Hand-crafted sterling silver Seal of Solomon amulet on an 18-inch chain.','lore'=>'The Seal of Solomon has commanded spirits and protected its wearer since antiquity.','price'=>54.99,'original_price'=>null,'type'=>'physical','category_id'=>$catMap['amulets'],'tags'=>['amulet','silver'],'rating'=>4.7,'review_count'=>44,'in_stock'=>true,'featured'=>false,'is_new'=>false,'is_bestseller'=>false],
            ['name'=>'Black Moon Ritual Candle Set','slug'=>'black-moon-ritual-candle-set','description'=>'Set of 7 hand-poured black beeswax ritual candles infused with onycha and mugwort.','lore'=>'Each candle burns for 12 hours, releasing a veil of sacred smoke.','price'=>24.99,'original_price'=>34.99,'type'=>'physical','category_id'=>$catMap['candles'],'tags'=>['candles','ritual'],'rating'=>4.6,'review_count'=>189,'in_stock'=>true,'featured'=>false,'is_new'=>true,'is_bestseller'=>false],
        ];
        foreach ($products as $p) { Product::firstOrCreate(['slug'=>$p['slug']], $p); }

        // ── Digital file attachments (secure download delivery demo) ────────
        $digitalFiles = [
            'crimson-codex-digital' => ['path' => 'digital-seed-content/crimson-codex.txt', 'name' => 'The-Crimson-Codex.txt'],
            'digital-tarot-guidebook' => ['path' => 'digital-seed-content/tarot-guidebook.txt', 'name' => 'Digital-Tarot-Guidebook.txt'],
        ];
        foreach ($digitalFiles as $slug => $file) {
            $product = Product::where('slug', $slug)->first();
            if ($product && ! $product->file_path) {
                $product->update([
                    'file_path' => $file['path'],
                    'file_name' => $file['name'],
                    'file_size' => @filesize(storage_path('app/' . $file['path'])) ?: null,
                ]);
            }
        }

        // ── Blog Posts ─────────────────────────────────────────────────────
        $posts = [
            ['title'=>'The Art of Shadow Magic: A Beginner\'s Guide','slug'=>'shadow-magic-beginners-guide','excerpt'=>'Explore the ancient tradition of shadow work and learn how to harness the hidden power within the darkness of your own soul.','content'=>'Shadow magic is one of the oldest and most misunderstood branches of the arcane arts. Unlike the bright flames of solar magic, shadow work requires you to descend into the depths of your own subconscious — to face the parts of yourself you have long kept hidden. This guide will walk you through the fundamental principles, helping you begin your journey with clarity and safety. The first step is always grounding. Before any shadow work can begin, you must establish a firm connection to the present moment...','author'=>'Morgantha Vex','tags'=>['shadow-magic','beginners','rituals'],'featured'=>true,'published_at'=>now()->subDays(3),'reading_time'=>8],
            ['title'=>'Moon Phase Magic: Harnessing Lunar Energy for Your Spells','slug'=>'moon-phase-magic-guide','excerpt'=>'Learn how the waxing, full, waning, and dark moon each carry distinct magical properties that can amplify your practice.','content'=>'The moon is the most powerful celestial influence on magical practice. Each phase offers unique energies that skilled practitioners learn to work with rather than against. The New Moon represents new beginnings and is ideal for setting intentions. The Waxing Moon builds momentum. The Full Moon is peak power. The Waning Moon releases what no longer serves...','author'=>'Elder Caius','tags'=>['moon','lunar-magic','intermediate'],'featured'=>true,'published_at'=>now()->subDays(7),'reading_time'=>6],
            ['title'=>'5 Crystals Every Witch Needs on Their Altar','slug'=>'essential-altar-crystals','excerpt'=>'From black tourmaline to selenite, discover the five crystals that form the foundation of any powerful magical practice.','content'=>'Building an altar is one of the first acts of a practicing witch, and crystals are among its most important components. Each crystal carries a unique vibrational frequency. The five essentials: Black Tourmaline, Clear Quartz, Obsidian, Amethyst, Rose Quartz...','author'=>'Morgantha Vex','tags'=>['crystals','altar','beginners'],'featured'=>false,'published_at'=>now()->subDays(14),'reading_time'=>5],
        ];
        foreach ($posts as $p) { BlogPost::firstOrCreate(['slug'=>$p['slug']], $p); }

        // ── Library Entries ────────────────────────────────────────────────
        $entries = [
            ['title'=>'The Binding Spell of Seven Shadows','slug'=>'binding-spell-seven-shadows','category'=>'Spells','excerpt'=>'An ancient binding working from the medieval grimoire tradition, adapted for modern practitioners.','content'=>'This binding working originates from a 13th-century manuscript found in the monastery of San Cipriano. The original text, written in corrupt Latin and Catalan, describes a ritual for binding harmful energies to a vessel of obsidian. Materials required: black thread (silk preferred), obsidian or black tourmaline, a candle of pure beeswax, and parchment inscribed with the intention...','difficulty'=>'Intermediate','tags'=>['binding','protection','medieval'],'featured'=>true],
            ['title'=>'Full Moon Releasing Ritual','slug'=>'full-moon-releasing-ritual','category'=>'Rituals','excerpt'=>'Harness the powerful energy of the full moon to release what no longer serves you.','content'=>'The full moon is the most potent time in the lunar cycle for releasing magic. Begin by cleansing your space with sage, palo santo, or simply salt water sprinkled at the thresholds. Set up your altar facing east — the direction of new beginnings. Bring your burdens into that light and release them to the cosmos...','difficulty'=>'Beginner','tags'=>['moon','releasing','full-moon'],'featured'=>true],
            ['title'=>'The Elder Futhark: A Complete Guide to Norse Rune Reading','slug'=>'elder-futhark-complete-guide','category'=>'Runes','excerpt'=>'Master the 24 runes of the Elder Futhark, understanding their individual meanings and origins.','content'=>'The Elder Futhark is the oldest form of the runic alphabet, used by Germanic tribes from roughly the 2nd to 8th centuries CE. Each of the 24 runes is not merely a letter but a cosmic force — a condensed symbol containing entire worlds of meaning. Fehu, the first rune, speaks of cattle, wealth, and the mobile nature of fortune...','difficulty'=>'Advanced','tags'=>['runes','norse','divination'],'featured'=>true],
            ['title'=>'Amethyst: Crystal of Dreams and Spiritual Protection','slug'=>'amethyst-crystal-guide','category'=>'Crystals','excerpt'=>'Discover the rich magical and metaphysical properties of amethyst.','content'=>'Amethyst, with its stunning violet hues ranging from pale lavender to deep purple-black, has been a stone of spiritual significance since at least ancient Greece. In crystal magic, amethyst enhances psychic abilities and intuition, protects the aura, calms an overactive mind, and facilitates access to higher states of consciousness...','difficulty'=>'Beginner','tags'=>['crystals','amethyst','psychic'],'featured'=>false],
        ];
        foreach ($entries as $e) { LibraryEntry::firstOrCreate(['slug'=>$e['slug']], $e); }

        // ── Testimonials ───────────────────────────────────────────────────
        $testimonials = [
            ['author'=>'Seraphina M.','location'=>'New Orleans, USA','content'=>'The Shadow Moon Ritual Kit transformed my practice completely. Every element is chosen with intention — the obsidian sphere alone is worth the price. This is the real thing.','rating'=>5,'product'=>'Shadow Moon Ritual Kit'],
            ['author'=>'Dorian K.','location'=>'Edinburgh, Scotland','content'=>'The Arcane Tarot Deck surpassed every expectation. The gold foil catches candlelight in the most magical way. My readings have become deeper and more nuanced.','rating'=>5,'product'=>'The Arcane Tarot Deck — Gold Edition'],
            ['author'=>'Isolde V.','location'=>'Amsterdam, Netherlands','content'=>'I was skeptical about ordering crystals online. The obsidian spheres are absolutely stunning. The largest one is perfectly polished and I can use it for scrying.','rating'=>4,'product'=>'Obsidian Sphere Collection'],
            ['author'=>'Caspian R.','location'=>'Melbourne, Australia','content'=>'The Crimson Codex is extraordinary. 300 pages of genuinely useful content — no fluff. The chapters on planetary hours alone are worth triple the price.','rating'=>5,'product'=>'The Crimson Codex — Digital Grimoire'],
            ['author'=>'Lyra N.','location'=>'Berlin, Germany','content'=>'The Elder Futhark Rune Set in black onyx is the most beautiful rune set I have ever held. The engravings are precise and deep. Worth every penny.','rating'=>5,'product'=>'Elder Futhark Rune Set — Black Onyx'],
            ['author'=>'Theron A.','location'=>'Chicago, USA','content'=>'Fast shipping, exceptional packaging, and a personal note from the shop. The Black Moon Ritual Candles smell absolutely divine. Already reordered.','rating'=>4,'product'=>'Black Moon Ritual Candle Set'],
        ];
        foreach ($testimonials as $t) { Testimonial::firstOrCreate(['author'=>$t['author'],'product'=>$t['product']], $t); }
    }
}
