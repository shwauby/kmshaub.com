<?php
/**
 * Rest API functions
 *
 * @package visual-portfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

/**
 * Class Visual_Portfolio_Rest
 */
class Visual_Portfolio_Rest extends WP_REST_Controller {
    /**
     * Namespace.
     *
     * @var string
     */
    protected $namespace = 'visual-portfolio/v';

    /**
     * Version.
     *
     * @var string
     */
    protected $version = '1';

    /**
     * Visual_Portfolio_Rest constructor.
     */
    public function __construct() {
        add_action( 'rest_api_init', array( $this, 'register_routes' ) );
    }

    /**
     * Register rest routes.
     */
    public function register_routes() {
        $namespace = $this->namespace . $this->version;

        // Get layouts list.
        register_rest_route(
            $namespace,
            '/get_layouts/',
            array(
                'methods'             => WP_REST_Server::READABLE,
                'callback'            => array( $this, 'get_layouts' ),
                'permission_callback' => array( $this, 'get_layouts_permission' ),
            )
        );

        // Update layout data.
        register_rest_route(
            $namespace,
            '/update_layout/',
            array(
                'methods'             => WP_REST_Server::EDITABLE,
                'callback'            => array( $this, 'update_layout' ),
                'permission_callback' => array( $this, 'update_layout_permission' ),
            )
        );
    }

    /**
     * Get layout data permission.
     *
     * @return mixed
     */
    public function get_layouts_permission() {
        if ( ! current_user_can( 'read_posts' ) ) {
            return $this->error( 'vpf_data_cannot_read', esc_html__( 'Sorry, you are not allowed to read saved layouts data.', 'visual-portfolio' ) );
        }

        return true;
    }

    /**
     * Get layout data.
     *
     * @return mixed
     */
    public function get_layouts() {
        // get all visual-portfolio post types.
        // Don't use WP_Query on the admin side https://core.trac.wordpress.org/ticket/18408 .
        $layouts  = array();
        $vp_query = get_posts(
            array(
                'post_type'      => 'vp_lists',
                'posts_per_page' => -1,
                'showposts'      => -1,
                'paged'          => -1,
            )
        );
        foreach ( $vp_query as $post ) {
            $layouts[] = array(
                'id'       => $post->ID,
                'title'    => $post->post_title,
                'edit_url' => admin_url( 'post.php?post=' . $post->ID ) . '&action=edit',
            );
        }

        if ( ! empty( $layouts ) ) {
            return $this->success( $layouts );
        } else {
            return $this->error( 'no_layouts_found', __( 'Layouts not found.', 'visual-portfolio' ) );
        }
    }

    /**
     * Update layout data permission.
     *
     * @return mixed
     */
    public function update_layout_permission() {
        if ( ! current_user_can( 'edit_posts' ) ) {
            return $this->error( 'vpf_data_cannot_read', esc_html__( 'Sorry, you are not allowed to edit saved layouts data.', 'visual-portfolio' ) );
        }

        return true;
    }

    /**
     * Update layout data.
     *
     * @param WP_REST_Request $request Full details about the request.
     *
     * @return WP_REST_Response|WP_Error Response object on success, or WP_Error object on failure.
     */
    public function update_layout( $request ) {
        $post_id = isset( $request['post_id'] ) ? intval( $request['post_id'] ) : 0;
        $data    = isset( $request['data'] ) ? $request['data'] : false;

        if ( $post_id && $data ) {
            $meta = array_keys( Visual_Portfolio_Get::get_options( array( 'id' => $post_id ) ) );

            foreach ( $meta as $name ) {
                // Save with prefix.
                $prefixed_name = 'vp_' . $name;

                if ( isset( $data[ $prefixed_name ] ) ) {
                    if (
                        'vp_images' === $prefixed_name ||
                        'vp_layout_elements' === $prefixed_name ||
                        'vp_custom_css' === $prefixed_name
                    ) {
                        $result = $data[ $prefixed_name ];
                    } elseif ( is_array( $data[ $prefixed_name ] ) ) {
                        $result = array_map( 'sanitize_text_field', wp_unslash( $data[ $prefixed_name ] ) );
                    } else {
                        $result = sanitize_text_field( wp_unslash( $data[ $prefixed_name ] ) );
                    }

                    update_post_meta( $post_id, $prefixed_name, $result );
                } else {
                    update_post_meta( $post_id, $prefixed_name, false );
                }
            }
        }

        return $this->success( $meta );
    }

    /**
     * Success rest.
     *
     * @param mixed $response response data.
     * @return mixed
     */
    public function success( $response ) {
        return new WP_REST_Response(
            array(
                'success'  => true,
                'response' => $response,
            ),
            200
        );
    }

    /**
     * Error rest.
     *
     * @param mixed $code     error code.
     * @param mixed $response response data.
     * @return mixed
     */
    public function error( $code, $response ) {
        return new WP_REST_Response(
            array(
                'error'      => true,
                'success'    => false,
                'error_code' => $code,
                'response'   => $response,
            ),
            401
        );
    }
}

new Visual_Portfolio_Rest();
