<?php
/**
 * @package AyonLiu
 */

class WXLogin {
    // Declare the MyStyle property before use.
    protected string $namespace;
    protected string $resource_name;

    const CODE2SESSION= 'https://api.weixin.qq.com/sns/jscode2session';

    // initialize namespace and resource name.
    public function __construct() {
      $this->namespace     = '/wxauth/v1';
      $this->resource_name = 'login';
    }

    // Register routes.
    public function register_routes() {
      register_rest_route( 
        $this->namespace,
        '/' . $this->resource_name,
        [
          // Here we register the readable endpoint for collections.
          [
              'methods'   => 'GET',
              'callback'  => array( $this, 'get_items' ),
              'permission_callback' => array( $this, 'get_items_permissions_check' ),
          ],
        ]
      );
      register_rest_route( 
        $this->namespace,
        '/' . $this->resource_name,
        [
          // Here we register the readable endpoint for collections.
          [
              'methods'   => 'POST',
              'callback'  => array( $this, 'get_items' ),
              'permission_callback' => array( $this, 'get_items_permissions_check' ),
          ],
        ]
      );
    }

    /**
     *
     * @param WP_REST_Request $request Current request.
     */
    public function get_items( $request ) {
        // Return response data.
        // var_dump($request);
        $code = $request->get_param('code');
        $params = [
            'appid' => WX_APPID,
            'secret' => WX_SECRET,
            'js_code' => $code,
            'grant_type' => 'authorization_code'
        ];
        $code2session_url = self::CODE2SESSION . '?' . http_build_query($params);
        $response = wp_remote_get( $code2session_url );
        $body     = wp_remote_retrieve_body( $response );
        // return rest_ensure_response( $request->get_params() );
        return rest_ensure_response( json_decode($body) );
    }
      /**
     * Check permissions
     *
     * @param WP_REST_Request $request Current request.
     */
    public function get_items_permissions_check( $request ) {
        // if ( ! current_user_can( 'read' ) ) {
        //     return new WP_Error( 'rest_forbidden', esc_html__( 'You cannot view the post resource.' ), array( 'status' => $this->authorization_status_code() ) );
        // }
        return true;
    }
    // Sets up the proper HTTP status code for authorization.
    public function authorization_status_code() {

        $status = 401;

        if ( is_user_logged_in() ) {
            $status = 403;
        }

        return $status;
    }
}

// Function to register our new routes from the controller.
// function wxauth_register_routes() {
//   $controller = new WXLogin();
//   $controller->register_routes();
// }

// add_action( 'rest_api_init', 'wxauth_register_routes' );