<?php
include_once "wxBizDataCrypt.php";

class WXDecrypt {
    // Declare the MyStyle property before use.
    protected string $namespace;
    protected string $resource_name;

    // initialize namespace and resource name.
    public function __construct() {
      $this->namespace     = '/wxauth/v1';
      $this->resource_name = 'decrypt';
    }

    // Register routes.
    public function register_routes() {
      register_rest_route(
        $this->namespace,
        '/' . $this->resource_name,
        [
          // Here we register the readable endpoint for collections.
          [
              'methods'   => 'POST',
              'callback'  => array( $this, 'decrypt' ),
              'permission_callback' => array( $this, 'get_items_permissions_check' ),
          ],
        ]
      );
    }

    /**
     *
     * @param WP_REST_Request $request Current request.
     */
    public function decrypt( $request ) {
        // Return response data.
        // var_dump($request);
        $params = $request->get_json_params();
        
        // $pc = new WXBizDataCrypt(WX_APPID, $sessionKey);
        // $errCode = $pc->decryptData($encryptedData, $iv, $data );

        // if ($errCode == 0) {
        //     print($data . "\n");
        // } else {
        //     print($errCode . "\n");
        // }
        // return rest_ensure_response( $request->get_params() );
        return rest_ensure_response( $params );
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
// function decrypt_register_routes() {
//   $controller = new WXDecrypt();
//   $controller->register_routes();
// }

// add_action( 'rest_api_init', 'decrypt_register_routes' );