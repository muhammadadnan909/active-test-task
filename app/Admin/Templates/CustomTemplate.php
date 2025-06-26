<?php

// app/Admin/Templates/CustomTemplate.php

namespace App\Admin\Templates;

use SleepingOwl\Admin\Templates\TemplateDefault;

class CustomTemplate extends TemplateDefault
{
    public function getLayoutView()
    {
        return 'admin.layouts.master'; // Optional: your own layout if needed
    }
}

