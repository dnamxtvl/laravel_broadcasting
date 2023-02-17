<?php
return [
    'User' => [
        'title' => 'Danh sách User',
        'controller' => 'UserController',
        'model' => 'User',
        'permissions' => [
            'users_index' => 'Danh sách User',
            'users_create' => 'Tạo mới User',
            'users_store' => 'Thêm User',
            'users_destroy' => 'Xóa User',
            'users_edit' => 'Sửa User',
            'users_update' => 'Cập nhật User',
            'users_exportUser' => 'Xuất excel User'
        ],
    ],
    'Role' => [
        'title' => 'Nhóm Quyền',
        'controller' => 'RoleController',
        'model' => 'Role',
        'permissions' => [
            'roles_index' => 'Danh sách Role',
            'roles_create' => 'Tạo mới Role',
            'roles_store' => 'Thêm Role',
            'roles_destroy' => 'Xóa Role',
            'roles_edit' => 'Sửa Role',
            'roles_update' => 'Cập nhật Role'
        ],
    ],
    'Article' => [
        'title' => 'Danh sách Article',
        'controller' => 'ArticleController',
        'model' => 'Article',
        'permissions' => [
            'articles_index' => 'Danh sách Article',
            'articles_create' => 'Tạo mới Article',
            'articles_store' => 'Thêm Article',
            'articles_destroy' => 'Xóa Article',
            'articles_edit' => 'Sửa Article',
            'articles_update' => 'Cập nhật Article'
        ],
    ]
];
?>