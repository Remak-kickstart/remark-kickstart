<?php
Class extension_less extends Extension
{
    // About this extension:
    public function about()
    {
        return array(
            'name' => 'LESS CSS for Symphony',
            'version' => '0.1',
            'release-date' => '2010-12-20',
            'author' => array(
                'name' => 'Giel Berkers',
                'website' => 'http://www.gielberkers.com',
                'email' => 'info@gielberkers.com'),
            'description' => 'LESS CSS (php implementation) for Symphony'
        );
    }

    // Set the delegates:
    public function getSubscribedDelegates()
    {
        return array(
            array(
                'page' => '/frontend/',
                'delegate' => 'FrontendOutputPostGenerate',
                'callback' => 'convertLessToCSS'
            ),
        );
    }

    public function convertLessToCSS($output)
    {
        // Load the PHP Less-compiler:
        require_once EXTENSIONS . '/less/lib/lessphp/lessc.inc.php';

        // Match less-stylesheets:
        preg_match_all('/<link.*href="(.*).less".*(\/)?>/i', $output['output'], $matches);
        foreach ($matches[1] as $match)
        {
            $local = false;
            $file = str_replace(URL, '', $match . '.less');
            if (substr($file, 0, 7) != 'http://') {
                $local = true;
                $file = DOCROOT . str_replace(URL, '', $match . '.less');
            }

            if ($local) {
                // Check if the file is modified:
                if (file_exists($file)) {
                    // Create a realy tiny time hash:
                    $time = substr(md5(filemtime($file)), 0, 4);
                    $cachedFile = $match . '.cache.' . $time . '.css';

                    $cachedPath = DOCROOT . str_replace(URL, '', $cachedFile);

                    // Check if the cached file exists:
                    //if (!file_exists($cachedPath)) {
                        // File does not exist, create it:

                        // First delete all previously cached files:
                        $pattern = str_replace('.less', '.cache.*.css', $file);
                        $files = glob($pattern);

                        foreach ($files as $oldFile)
                        {
                            unlink($oldFile);
                        }

                        try {
                            lessc::ccompile($file, $cachedPath);
                        } catch (exception $ex) {
                            exit($ex->getMessage());
                        }


                    //}

                    // Replace the output:
                    $output['output'] = str_replace($match . '.less', $cachedFile, $output['output']);
                }
            }
        }
    }
}

?>