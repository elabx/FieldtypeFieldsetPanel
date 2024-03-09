<?php namespace ProcessWire;

require_once(wire('config')->paths->modules . "Fieldtype/FieldtypeFieldsetOpen.module");

class InputfieldFieldsetPanelOpen extends InputfieldFieldsetOpen
{
    public function __construct()
    {
        parent::__construct();

        $this->set('skipLabel', Inputfield::skipLabelHeader);
        $this->set('collapsed', Inputfield::collapsedNever);

    }

    public function ___render()
    {
        foreach ($this->children as $c) {
            $c->collapsed = Inputfield::collapsedHidden;
        }

        $editUrl = $this->getEditURL();
        if($this->icon){
            $icon = "<span class='fa fa-{$this->icon}'></span>";
        }
        return "<div class=''> <a class='pw-panel' href='$editUrl'>{$icon} {$this->label}</a></div>";

    }

    public function ___getEditUrl()
    {
        $page = $this->hasPage;
        $process_edit = $this->page;
        if ($page && $this->process == "ProcessPageEdit") {
            $fields = $this->children->implode(',', function ($item) {
                // Check for repeater fields
                $pattern = '/_repeater\d+$/';
                return preg_replace($pattern, '', $item->name);
            });
            return $process_edit->url([
              'data' => [
                'id'     => $page->id,
                'fields' => $fields
              ]
            ]);
        }
    }
}

class FieldtypeFieldsetPanelOpen extends FieldtypeFieldsetOpen
{
    public static function getModuleInfo()
    {
        return array(
          'title'     => 'Fieldset Panel (Open)',
          'version'   => 100,
          'summary'   => 'Open a fieldset to group fields. Should be followed by a Fieldset (Close) after one or more fields.',
          'permanent' => true,
        );
    }

    public function init()
    {

        // TODO Not working :/
        $this->addHookBefore('InputfieldFieldsetPanelOpen::render', function ($e) {
            //$markup = InputfieldWrapper::getMarkup();
            //$markup['item_label'] = "<label class='sr-only uk-form-label' for='{for}'></label>";
            //InputfieldWrapper::setMarkup($markup);
            // TODO Make hook after
            //bd($e->object);
            //$e->object->addHookAfter('InputfieldWrapper::render', function($e) use ($markup){
            //bd($e);
            //InputfieldWrapper::setMarkup($markup);
            //});
        });

    }

    public function getInputfield(Page $page, Field $field)
    {
        /** @var InputfieldFieldsetPanelOpen $inputfield */
        $inputfield = $this->wire(new InputfieldFieldsetPanelOpen());
        $inputfield->class = $this->className();
        return $inputfield;
    }
}