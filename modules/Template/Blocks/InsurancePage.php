<?php
namespace Modules\Template\Blocks;
class InsurancePage extends BaseBlock
{
    public function __construct()
    {
        $this->setOptions([
            'settings' => [
                [
                    'id'    => 'content',
                    'type'  => 'editor',
                    'label' => __('Editor')
                ],
                [
                    'id'        => 'class',
                    'type'      => 'input',
                    'inputType' => 'text',
                    'label'     => __('Wrapper Class (opt)')
                ],
//                [
//                    'id'    => 'bg',
//                    'type'  => 'uploader',
//                    'label' => __('Image Uploader')
//                ],
            ]
        ]);
    }
  
    public function getName()
    {
        return __('InsurancePage');
    }

    public function content($model = [])
    {
        
        //include( '/home/u7424045/public_html/vacamania.com/vendor/insurance/InsuranceForm.php' );
        //return "testtest";
        return view('Template::frontend.blocks.insurance_page', $model);
    }
}