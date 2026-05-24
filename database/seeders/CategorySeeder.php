<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Service;
use App\Models\Subcategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $structure = [
            [
                'name' => 'Software Development',
                'icon' => '💻',
                'color' => '#00b4ff',
                'short' => 'Custom web, mobile, and enterprise software built to scale.',
                'description' => 'We design and build robust software products — from MVPs to mission-critical enterprise systems. Modern stacks, clean code, and a relentless focus on shipping what users need.',
                'subs' => [
                    ['Web Development', '🌐', 'Performant, SEO-friendly web platforms.'],
                    ['Mobile App Development', '📱', 'Native and cross-platform mobile apps.'],
                    ['Enterprise Software', '🏢', 'ERP, CRM, and bespoke internal tools.'],
                    ['E-Commerce Platforms', '🛒', 'Custom storefronts and checkout flows.'],
                    ['API Development', '🔌', 'REST & GraphQL APIs that scale.'],
                    ['SaaS Product Development', '☁️', 'Multi-tenant SaaS from idea to launch.'],
                ],
            ],
            [
                'name' => 'AI & Machine Learning',
                'icon' => '🤖',
                'color' => '#a855f7',
                'short' => 'Custom AI models and LLM integrations that transform how you operate.',
                'description' => 'From predictive analytics to LLM-powered assistants and computer vision pipelines — we build AI that solves real business problems.',
                'subs' => [
                    ['Custom AI Models', '🧠', 'ML models trained on your data.'],
                    ['LLM Integration', '💬', 'GPT, Claude, and open-source LLMs.'],
                    ['Computer Vision', '👁️', 'Image & video understanding.'],
                    ['Predictive Analytics', '📊', 'Forecasting and decision intelligence.'],
                    ['NLP Solutions', '📝', 'Text classification, extraction, summarisation.'],
                    ['MLOps & Deployment', '⚙️', 'Production AI infrastructure.'],
                ],
            ],
            [
                'name' => 'Cloud Solutions',
                'icon' => '☁️',
                'color' => '#39d353',
                'short' => 'AWS, Azure & GCP expertise for the modern enterprise.',
                'description' => 'We architect, migrate, and manage cloud infrastructure that is secure, cost-effective, and built for scale.',
                'subs' => [
                    ['Cloud Migration', '🚀', 'Lift-and-shift to cloud-native moves.'],
                    ['Cloud Architecture', '🏗️', 'Multi-region, fault-tolerant systems.'],
                    ['DevOps & CI/CD', '🔄', 'Automated pipelines and infrastructure as code.'],
                    ['Kubernetes & Docker', '📦', 'Containerised production environments.'],
                    ['Serverless Solutions', '⚡', 'AWS Lambda, Azure Functions, Cloud Run.'],
                    ['Managed Cloud Ops', '🛠️', '24/7 monitoring and managed services.'],
                ],
            ],
            [
                'name' => 'Cyber Security',
                'icon' => '🛡️',
                'color' => '#ff3b5c',
                'short' => 'Enterprise security from pen testing to compliance.',
                'description' => 'End-to-end cyber security services that protect your business, your data, and your reputation.',
                'subs' => [
                    ['Penetration Testing', '🎯', 'Find vulnerabilities before attackers do.'],
                    ['Vulnerability Assessment', '🔍', 'Continuous scanning and reporting.'],
                    ['Compliance & Audit', '📋', 'ISO 27001, SOC2, GDPR readiness.'],
                    ['Incident Response', '⚠️', 'Rapid response and post-mortem.'],
                    ['Data Protection', '🔐', 'Encryption, DLP, and privacy controls.'],
                    ['Security Operations', '👮', 'SOC, SIEM, and threat monitoring.'],
                ],
            ],
            [
                'name' => 'Digital Marketing',
                'icon' => '📈',
                'color' => '#ff8c00',
                'short' => 'Data-driven growth marketing that compounds.',
                'description' => 'SEO, paid campaigns, content, and analytics that grow brands beyond vanity metrics.',
                'subs' => [
                    ['SEO Services', '🔍', 'Technical SEO and content optimisation.'],
                    ['PPC Advertising', '💰', 'Google, Meta, LinkedIn paid campaigns.'],
                    ['Social Media Marketing', '📱', 'Content, community, and growth.'],
                    ['Content Strategy', '✍️', 'Editorial planning and execution.'],
                    ['Email Marketing', '✉️', 'Lifecycle and transactional sequences.'],
                    ['Conversion Optimisation', '🎯', 'A/B testing and funnel improvements.'],
                ],
            ],
            [
                'name' => 'IT Consulting',
                'icon' => '💼',
                'color' => '#ffd700',
                'short' => 'Strategic technology advisory aligned to business outcomes.',
                'description' => 'Strategic guidance from leaders who have shipped at scale — from technology roadmaps to team augmentation.',
                'subs' => [
                    ['Technology Strategy', '🗺️', 'Tech roadmaps aligned to your goals.'],
                    ['Digital Transformation', '🔄', 'Modernising legacy systems and processes.'],
                    ['Team Augmentation', '👥', 'Embedded engineers and specialists.'],
                    ['Architecture Review', '🏛️', 'Independent audits of your stack.'],
                    ['Process Automation', '⚙️', 'RPA and intelligent workflow automation.'],
                    ['Data Strategy', '📊', 'Data platform and analytics blueprints.'],
                ],
            ],
        ];

        foreach ($structure as $catSort => $cat) {
            $category = Category::updateOrCreate(
                ['slug' => Str::slug($cat['name'])],
                [
                    'name' => $cat['name'],
                    'icon' => $cat['icon'],
                    'color' => $cat['color'],
                    'short_description' => $cat['short'],
                    'description' => $cat['description'],
                    'meta_title' => $cat['name'] . ' Services | LEAMSOFT',
                    'meta_description' => $cat['short'],
                    'keywords' => strtolower($cat['name']) . ', leamsoft, it services',
                    'sort_order' => $catSort,
                    'featured' => 1,
                    'status' => 1,
                ]
            );

            foreach ($cat['subs'] as $subSort => [$subName, $subIcon, $subShort]) {
                $subcategory = Subcategory::updateOrCreate(
                    ['slug' => Str::slug($subName)],
                    [
                        'category_id' => $category->id,
                        'name' => $subName,
                        'icon' => $subIcon,
                        'short_description' => $subShort,
                        'description' => $subShort . ' Our team delivers production-grade ' . strtolower($subName) . ' tailored to your business goals.',
                        'meta_title' => $subName . ' | LEAMSOFT',
                        'meta_description' => $subShort,
                        'keywords' => strtolower($subName) . ', leamsoft',
                        'sort_order' => $subSort,
                        'status' => 1,
                    ]
                );

                Service::updateOrCreate(
                    ['slug' => Str::slug($subName)],
                    [
                        'category_id' => $category->id,
                        'subcategory_id' => $subcategory->id,
                        'name' => $subName,
                        'icon' => $subIcon,
                        'image_alt' => $subName,
                        'short_description' => $subShort,
                        'description' => '<p>' . $subShort . '</p><p>At LEAMSOFT, our ' . strtolower($subName) . ' practice combines deep technical expertise with a clear business focus. We follow industry best practices, write tested code, and ship continuously.</p><h3>What you get</h3><ul><li>Senior engineers with shipped portfolio</li><li>Transparent agile delivery with weekly demos</li><li>Modern stack chosen for your specific case</li><li>Documentation, handover and ongoing support</li></ul>',
                        'meta_title' => $subName . ' Services | LEAMSOFT',
                        'meta_description' => $subShort,
                        'keywords' => strtolower($subName) . ', leamsoft, it services',
                        'h1_tag' => $subName,
                        'price' => 0,
                        'mrp_price' => 0,
                        'discount' => 0,
                        'gst' => 0,
                        'tax' => 0,
                        'sort_order' => $subSort,
                        'featured' => $subSort < 2 ? 1 : 0,
                        'top' => $subSort < 3 ? 1 : 0,
                        'status' => 1,
                        'uid' => 1,
                    ]
                );
            }
        }
    }
}
