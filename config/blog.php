<?php

return [
    'uploads' => [
        'storage' => 'upload',
        'webPath' => '/uploads'
    ],
    'system_key' => [
        'blog_name',
        'motto',
        'title',
        'seo_keyword',
        'seo_desc',
        'icp',
        'github_url',
        'qq',
//        'disqus_short_name',
//        'duoshuo_short_name',
        'comment_plugin',
        'statistics_script',
        'comment_script'
    ],
    'menu' => [
        [
            'admin.home' => [
                'icon'  => 'fa fa-home',
                'name'  => 'web端管理'
            ]
        ],
        [
            'tree_title' => [
                'icon' => 'fa fa-files-o',
                'name' => '文章'
            ],
            'admin.article.index' => [
                'icon' => '',
                'name' => '文章管理'
            ],
            'admin.article.create' => [
                'icon' => '',
                'name' => '发布文章'
            ],
            'admin.category.index' => [
                'icon' => '',
                'name' => '文章分类'
            ]
        ],
        [
            'admin.comment.index'=>[
                'icon'=>'fa fa-comments',
                'name'=>'评论'
            ]
        ],
        [
            'admin.tag.index' => [
                'icon' => 'fa fa-tags',
                'name' => '标签'
            ]
        ],
        [
            'admin.upload.index' => [
                'icon' => 'fa fa-file-image-o',
                'name' => '文件'
            ]
        ],
        [
            'admin.navigation.index' => [
                'icon' => 'fa fa-navicon',
                'name' => '导航'
            ]
        ],
        [
            'tree_title' => [
                'icon' => 'fa fa-user',
                'name' => '用户'
            ],
            'admin.user.index' => [
                'icon' => '',
                'name' => '用户管理'
            ],
            'admin.user.create' => [
                'icon' => '',
                'name' => '用户添加'
            ]
        ],
        [
            'tree_title' => [
                'icon' => 'fa fa-cog',
                'name' => '设置'
            ],
            'admin.system.index' => [
                'icon' => '',
                'name' => '系统设置'
            ],
            'admin.link.index' => [
                'icon' => '',
                'name' => '友情链接'
            ],
            'admin.page.index' => [
                'icon' => '',
                'name' => '自定义页面'
            ]
        ]
    ]
];
