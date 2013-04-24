<?php
/**
 * NOVIUS OS - Web OS for digital communication
 *
 * @copyright  2011 Novius
 * @license    GNU Affero General Public License v3 or (at your option) any later version
 *             http://www.gnu.org/licenses/agpl-3.0.html
 * @link http://www.novius-os.org
 */

namespace Lib\Blocs;

class Renderer_Selector extends \Nos\Renderer_Selector
{
    public function before_construct(&$attributes, &$rules)
    {
        $attributes['class'] = (isset($attributes['class']) ? $attributes['class'] : '').' bloc';

        if (empty($attributes['id'])) {
            $attributes['id'] = uniqid('bloc_');
        }
    }

    public function build()
    {
        return $this->template(static::renderer(array(
            'input_name' => $this->name,
            'selected' => array(
                // Converts null to 0
                'id' => (string) (int) $this->value,
            ),
            'treeOptions' => array(
                'context' => \Arr::get($this->renderer_options, 'context', null),
            ),
            'height' => \Arr::get($this->renderer_options, 'height', '150px'),
            'width' => \Arr::get($this->renderer_options, 'width', null),
        )));
    }

    /**
     * Returns a bloc selector renderer
     * @static
     * @param array $options
     */
    public static function renderer($options = array())
    {
        $options = \Arr::merge(array(
            'urlJson' => 'admin/lib_blocs/bloc/inspector/bloc/json',
            'reloadEvent' => 'Lib\\Blocs\\Model_Bloc',
            'input_name' => null,
            'selected' => array(
                'id' => null,
                'model' => 'Lib\\Blocs\\Model_Bloc',
            ),
            'columns' => array(
                array(
                    'dataKey' => 'title',
                ),
            ),
            'treeOptions' => array(
                'context' => null
            ),
            'height' => '150px',
            'width' => null,
            'contextChange' => true,
        ), $options);

        return (string) \Request::forge('admin/lib_blocs/bloc/inspector/bloc/list')->execute(
            array(
                'inspector/modeltree_radio',
                array(
                    'params' => $options,
                )
            )
        )->response();
    }
}
