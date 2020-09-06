<?php
/**
 * Created by PhpStorm.
 * User: whossun
 * Date: 16-7-30
 * Time: 下午5:54
 */

namespace Whossun\Notify;

use Illuminate\Session\SessionManager as Session;
use Illuminate\Config\Repository as Config;

class Notify
{
    /**
     * The session manager.
     * @var \Illuminate\Session\SessionManager
     */
    protected $session;
    /**
     * The Config Handler.
     *
     * @var \Illuminate\Contracts\Config\Repository
     */
    protected $config;
    /**
     * The messages in session.
     *
     * @var array
     */
    protected $messages = [];

    function __construct(Session $session, Config $config)
    {
        $this->session = $session;
        $this->config  = $config;
    }

    public function render()
    {
        $messages = $this->session->get('notify::messages');

        if (! $messages) $messages = [];

        $script = '<script type="text/javascript">';

        foreach ($messages as $message) {
            $config = (array) $this->config->get('notify.options');

            if (count($message['options'])) {
                $config = json_encode(array_merge($config, $message['options']));
            }

            $script .= 'UIkit.notification("' . $message['message'] . '", ' . $config .')';

        }

        $script .= '</script>';
        return $script;
    }

    /**
     *
     * Add a flash message to session.
     *
     * @param string $message The flash message content.
     * @param array  $options The custom options.
     *
     * @return void
     */
    protected function add($message, $options = [])
    {

        $this->messages[] = [
            'message' => $message,
            'options' => $options,
        ];
        $this->session->flash('notify::messages', $this->messages);
    }

    /**
     * Add an info flash message to session.
     *
     * @param string $message The flash message content.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function info($message,  $options = [])
    {
        $this->add($message, array_merge($options, ['status' => 'info']));
    }

    /**
     * Add a success flash message to session.
     *
     * @param string $message The flash message content.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function success($message, $options = [])
    {
        $this->add($message, array_merge($options, ['status' => 'success']));
    }

    /**
     * Add an warning flash message to session.
     *
     * @param string $message The flash message content.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function warning($message, $options = [])
    {
        $this->add($message, array_merge($options, ['status' => 'warning']));
    }

    /**
     * Add an error flash message to session.
     *
     * @param string $message The flash message content.
     * @param array  $options The custom options.
     *
     * @return void
     */
    public function danger($message, $options = [])
    {
        $this->add($message, array_merge($options, ['status' => 'danger']));
    }

}
