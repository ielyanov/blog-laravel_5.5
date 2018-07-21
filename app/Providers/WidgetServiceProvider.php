<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App;
use Blade;

class WidgetServiceProvider extends ServiceProvider
{
    public function boot()
    {
    /*
     * Регистрируется дирректива для шаблонизатора Blade
     * Пример обращаения к виджету: @widget('menu')
     * Можно передать параметры в виджет:
     * @widget('menu', [$data1,$data2...])
     */
      Blade::directive('widget', function ($name) {
        return "<?php echo app('widget')->show($name); ?>";
      });
    }
    public function register(){
      App::singleton('widget', function(){
        return new \App\Widgets\Widget();
      });
    }
}