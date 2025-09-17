<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ForumCategory;
use App\Models\ForumThread;
use App\Models\ForumPost;
use Illuminate\Support\Facades\Hash;

class ForumDataSeeder extends Seeder
{
    public function run()
    {
        // Create test users
        $users = [
            [
                'name' => 'John Doe',
                'email' => 'john@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Jane Smith',
                'email' => 'jane@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Mike Johnson',
                'email' => 'mike@example.com',
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Sarah Wilson',
                'email' => 'sarah@example.com',
                'password' => Hash::make('password'),
            ],
        ];

        foreach ($users as $userData) {
            User::firstOrCreate(['email' => $userData['email']], $userData);
        }

        // Create categories
        $categories = [
            [
                'name' => 'General Discussion',
                'description' => 'General automotive discussions and topics'
            ],
            [
                'name' => 'Car Reviews',
                'description' => 'Share your car reviews and experiences'
            ],
            [
                'name' => 'Buying & Selling',
                'description' => 'Tips and advice for buying and selling vehicles'
            ],
            [
                'name' => 'Technical Support',
                'description' => 'Get help with technical issues and maintenance'
            ],
            [
                'name' => 'Bike Discussion',
                'description' => 'Everything about motorcycles and bikes'
            ]
        ];

        foreach ($categories as $categoryData) {
            ForumCategory::firstOrCreate(['name' => $categoryData['name']], $categoryData);
        }

        $allUsers = User::all();
        $allCategories = ForumCategory::all();

        // Create threads with posts
        $threadsData = [
            [
                'category' => 'General Discussion',
                'title' => 'Welcome to Auto Jazeera Forum!',
                'posts' => [
                    [
                        'user' => 'john@example.com',
                        'body' => 'Welcome everyone to our new forum! This is a place where we can discuss everything related to automobiles. Feel free to share your experiences, ask questions, and help fellow car enthusiasts.',
                        'replies' => [
                            [
                                'user' => 'jane@example.com',
                                'body' => 'Thanks for setting this up! Looking forward to great discussions.'
                            ],
                            [
                                'user' => 'mike@example.com',
                                'body' => 'Awesome! Finally a place to discuss cars with like-minded people.'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'category' => 'Car Reviews',
                'title' => 'Toyota Corolla 2024 - My Experience',
                'posts' => [
                    [
                        'user' => 'jane@example.com',
                        'body' => 'I recently bought a Toyota Corolla 2024 and wanted to share my experience. The fuel efficiency is amazing - getting around 15km/l in city driving. The interior is comfortable and the infotainment system is user-friendly.',
                        'replies' => [
                            [
                                'user' => 'sarah@example.com',
                                'body' => 'How is the rear seat space? I am considering this for my family.'
                            ],
                            [
                                'user' => 'jane@example.com',
                                'body' => 'The rear seat space is decent for adults. My family of 4 fits comfortably.'
                            ]
                        ]
                    ],
                    [
                        'user' => 'mike@example.com',
                        'body' => 'What about the maintenance cost? Is it expensive compared to other brands?'
                    ]
                ]
            ],
            [
                'category' => 'Buying & Selling',
                'title' => 'Tips for First Time Car Buyers',
                'is_pinned' => true,
                'posts' => [
                    [
                        'user' => 'mike@example.com',
                        'body' => 'Here are some essential tips for first-time car buyers:\n\n1. Set a realistic budget\n2. Research the model thoroughly\n3. Check vehicle history\n4. Get a pre-purchase inspection\n5. Negotiate the price\n6. Understand financing options\n\nFeel free to add more tips!',
                        'replies' => [
                            [
                                'user' => 'john@example.com',
                                'body' => 'Great list! I would also add: Always test drive in different conditions (city, highway, parking).'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'category' => 'Technical Support',
                'title' => 'Engine Making Strange Noise - Need Help',
                'posts' => [
                    [
                        'user' => 'sarah@example.com',
                        'body' => 'My Honda Civic 2020 is making a strange knocking noise when I accelerate. It started last week and is getting worse. The car has 45,000 km on it. Any ideas what this could be?',
                        'replies' => [
                            [
                                'user' => 'mike@example.com',
                                'body' => 'Could be engine knock due to low octane fuel or carbon buildup. When did you last change your oil?'
                            ],
                            [
                                'user' => 'sarah@example.com',
                                'body' => 'Oil was changed 2 months ago. I usually use regular fuel, should I try premium?'
                            ],
                            [
                                'user' => 'john@example.com',
                                'body' => 'Try premium fuel first, but if the noise persists, get it checked by a mechanic immediately.'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'category' => 'Bike Discussion',
                'title' => 'Best Bikes Under 150cc in Pakistan',
                'posts' => [
                    [
                        'user' => 'john@example.com',
                        'body' => 'Looking for recommendations for bikes under 150cc. My priorities are fuel efficiency and reliability. Budget is around 200,000 PKR. What would you suggest?',
                        'replies' => [
                            [
                                'user' => 'jane@example.com',
                                'body' => 'Honda CG 125 is very reliable and fuel efficient. Parts are easily available too.'
                            ],
                            [
                                'user' => 'mike@example.com',
                                'body' => 'Yamaha YBR 125G is also a good option. Slightly more expensive but better build quality.'
                            ]
                        ]
                    ]
                ]
            ],
            [
                'category' => 'General Discussion',
                'title' => 'Electric Vehicles in Pakistan - Future or Fantasy?',
                'posts' => [
                    [
                        'user' => 'sarah@example.com',
                        'body' => 'With the rising fuel prices, I have been thinking about electric vehicles. Do you think EVs have a future in Pakistan? What are the main challenges we face?',
                        'replies' => [
                            [
                                'user' => 'john@example.com',
                                'body' => 'The main challenge is charging infrastructure. We need more charging stations across the country.'
                            ]
                        ]
                    ]
                ]
            ]
        ];

        foreach ($threadsData as $threadData) {
            $category = $allCategories->where('name', $threadData['category'])->first();
            $user = $allUsers->where('email', $threadData['posts'][0]['user'])->first();

            $thread = ForumThread::create([
                'category_id' => $category->id,
                'user_id' => $user->id,
                'title' => $threadData['title'],
                'is_pinned' => $threadData['is_pinned'] ?? false,
                'is_locked' => $threadData['is_locked'] ?? false,
            ]);

            foreach ($threadData['posts'] as $postData) {
                $postUser = $allUsers->where('email', $postData['user'])->first();
                
                $post = ForumPost::create([
                    'thread_id' => $thread->id,
                    'user_id' => $postUser->id,
                    'body' => $postData['body'],
                ]);

                // Create replies if they exist
                if (isset($postData['replies'])) {
                    foreach ($postData['replies'] as $replyData) {
                        $replyUser = $allUsers->where('email', $replyData['user'])->first();
                        
                        ForumPost::create([
                            'thread_id' => $thread->id,
                            'user_id' => $replyUser->id,
                            'parent_id' => $post->id,
                            'body' => $replyData['body'],
                        ]);
                    }
                }
            }
        }

        echo "Forum data seeded successfully!\n";
        echo "Test users created:\n";
        echo "- john@example.com (password: password)\n";
        echo "- jane@example.com (password: password)\n";
        echo "- mike@example.com (password: password)\n";
        echo "- sarah@example.com (password: password)\n";
    }
}