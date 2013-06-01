<?php

class SinEngine
{


    private static $view_path;
    private static $layout_path;

    private static $has_layout;

    // Array containing all of the sections in a view
    private static $sections = array();

    // Array containing all of the sections, when accessed -> pops off the last entry
    private static $last_section = array();


    // Start the rendering of the view
    public static function start($view_path, $variables = array())
    {
        static::$view_path = $view_path;

        // If the view exists get it contents
        if(!$view = file_get_contents($view_path))
        {
            return Error::code('500', 'Could not get contents of '.$view_path);
        }
        // If the view has a layout, process the layout
        if(static::hasLayout($view))
        {
            static::compile_layout(static::$layout_path);
            $view = preg_replace("#@layout\('(\w+)'\)#", '', $view);
            static::$has_layout = true;
        }

        // Compile the view
        static::compile_view($view);

        // Start output buffering and extract the variables so they can be used in the view and layout
        ob_start() and extract($variables, EXTR_SKIP);

        require 'sinning/storage/views/'.md5(static::$view_path);

        if(static::$has_layout)
        {
            require 'sinning/storage/layouts/'.md5(static::$layout_path);
        }
        // Stop output buffering and set it to $content which will be returned the $response in sinning.php, our main file
        $content = ob_get_clean();

        return $content;
    }

    // After compiling the view's contents, save it to sinning/storage/views
    public static function compile_view($view)
    {
        $view = static::compile($view);
        file_put_contents('sinning/storage/views/'.md5(static::$view_path), $view);
    }

    // After compiling the layout's contents, save it to sinning/storage/views
    public static function compile_layout($path)
    {
        if(!$layout = file_get_contents($path))
        {
            return Error::code('500', 'Could not get contents of '.$path);
        }
        $layout = static::compile($layout);
        file_put_contents('sinning/storage/layouts/'.md5(static::$layout_path), $layout);
    }

    // Compile the content
    public static function compile($view)
    {
        $view = static::compile_sections($view);
        $view = static::compile_yield($view);
        return $view;
    }

    // Check if view has a layout
    public static function hasLayout($view)
    {
        if(preg_match("#@layout\('(\w+)'\)#", $view, $layout))
        {
            static::$layout_path = 'application/views/'.$layout[1].'.sin.php';
            return true;
        }
    }

    // Replace sections tags with valid PHP syntax
    public static function compile_sections($view)
    {
        $pattern = static::pattern('section');
        $view =  preg_replace($pattern, '$1<?php SinEngine::startSection$2; ?>', $view);
        $view = preg_replace('/@endsection/', '<?php SinEngine::stopSection(); ?>', $view);
        return $view;
    }

    // Replace yield tag with valid PHP syntax
    public static function compile_yield($view)
    {
        $pattern = static::pattern('yield');
        $view = preg_replace($pattern, '$1<?php echo SinEngine::yield$2; ?>', $view);
        return $view;
    }

    // If a section starts, start output buffering and add the section's name to the $last_secion array
    public static function startSection($section)
    {
        ob_start() and static::$last_section[] = $section;
    }

    // If a section stops, get last section and add it into $sections with the output buffer's contents
    public static function stopSection()
    {
        static::extend($last = array_pop(static::$last_section), ob_get_clean());
        return $last;
    }

    // Add $section and content into $sections
    protected static function extend($section, $content)
    {
        static::$sections[$section] = $content;
    }

    // Retrieve a section from the $sections array
    public static function yield($section)
    {
        return (isset(static::$sections[$section])) ? static::$sections[$section] : '';
    }

    // Pattern to easily find tags
    public static function pattern($function)
    {
        return '/(\s*)@'.$function.'(\s*\(.*\))/';
    }

}