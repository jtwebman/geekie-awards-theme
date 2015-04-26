<?php

class TaxonomyOrderby {
	
	const ORDERBY_KEY = 'tax_orderby';
	
	private $_taxonomy_name;
	
	function getTaxonomyName() {
		return $this->_taxonomy_name;
	}
	
	function setTaxonomyName($name) {
		$this->_taxonomy_name = $name;
	}
	
	function getSetOptionsKey($term_id) {
		return 'tax_ ' . $this->getTaxonomyName() . '_' . $term_id;
	}
	
	function __construct($name) {
		$this->setTaxonomyName($name);
		
		add_action( $this->getTaxonomyName() . '_add_form_fields', array( &$this, 'add_meta_fields' ), 10, 2 );
		add_action( $this->getTaxonomyName() . '_edit_form_fields', array( &$this, 'edit_meta_fields' ), 10, 2 );
		add_action( 'edited_' . $this->getTaxonomyName(), array( &$this, 'save_custom_meta' ), 10, 2 );  
    	add_action( 'create_' . $this->getTaxonomyName(), array( &$this, 'save_custom_meta' ), 10, 2 );
		add_filter( 'manage_edit-' . $this->getTaxonomyName() . '_columns', array( &$this, 'edit_columns' ) ); 
		add_filter( 'manage_' . $this->getTaxonomyName() . '_custom_column', array( &$this, 'manage_grid_columns' ), 10, 3 );
		add_filter( 'manage_edit-' . $this->getTaxonomyName()  . '_sortable_columns', array( &$this, 'sortable_columns' ) );
		add_filter( 'get_terms', array( &$this, 'get_terms_filter' ), 10, 3 );
		add_filter( 'wp_get_object_terms', array( &$this, 'wp_get_object_terms' ), 10, 4);
		add_filter( 'get_the_terms', array( &$this, 'get_the_terms' ), 10, 3);
		add_filter( 'get_terms_orderby', array( &$this, 'get_terms_orderby' ), 10, 2);
	}
	
	function add_meta_fields() { ?>
        <div class="form-field">
            <label for="<?php echo self::ORDERBY_KEY ?>"><?php _e( 'Order By', wp_get_theme()->get( 'TextDomain' ) ); ?></label>
            <select name="<?php echo self::ORDERBY_KEY ?>" id="<?php echo self::ORDERBY_KEY ?>"><option> 
            <?php echo implode("<option>", range(1, 100));?> 
            </select>
            <p><?php _e( 'Will be ordered assending by this field.', wp_get_theme()->get( 'TextDomain' ) ); ?></p>
        </div>
    	<?php
    }
    
    
    function edit_meta_fields($term) {
        $term_meta = get_option( $this->getSetOptionsKey( $term->term_id ) ); ?>
        <tr class="form-field">
        <th scope="row" valign="top"><label for="<?php echo self::ORDERBY_KEY ?>"><?php _e( 'Order By', wp_get_theme()->get( 'TextDomain' ) ); ?></label></th>
            <td>
                <select name="<?php echo self::ORDERBY_KEY ?>" id="<?php echo self::ORDERBY_KEY ?>">
                <?php 
                for ($i = 1;$i < 101;$i++) 
                { 
                    $selected = $term_meta[ self::ORDERBY_KEY ] == $i ? " selected" : "";
                    echo '<option value="' . $i . '"' . $selected . '>' . $i . '</option>'; 
                } ?> 
                </select><br />
                <span class="description"><?php _e( 'Will be ordered assending by this field.', wp_get_theme()->get( 'TextDomain' ) ); ?></span>
            </td>
        </tr>
    	<?php
    }
   
    function save_custom_meta( $term_id ) {
        if ( isset( $_POST[ self::ORDERBY_KEY ] ) ) {
			$optionKey = $this->getSetOptionsKey( $term_id );
			
            $term_meta = get_option( $optionKey );
            $term_meta[ self::ORDERBY_KEY ] = $_POST[ self::ORDERBY_KEY ];
			
            update_option( $optionKey , $term_meta );
        }
    }  
    
    
    function edit_columns($columns) {
        $columns[ self::ORDERBY_KEY ] = __( 'Order By', wp_get_theme()->get( 'TextDomain' ) );
        return $columns;
    }
    
    
    function manage_grid_columns($out, $column_name, $term_id) {
        $t_id = $term_id;
        $term_meta = get_option( $this->getSetOptionsKey( $term_id ) );
        switch ($column_name) {
            case self::ORDERBY_KEY: 
				if ( is_array($term_meta) && array_key_exists( self::ORDERBY_KEY , $term_meta ) ) {
                	$out .= $term_meta[ self::ORDERBY_KEY ];
				}
                break;
            default:
                break;
        }
        return $out;
    }
    
    
    function sortable_columns( $columns ){
      $columns[ self::ORDERBY_KEY ] = self::ORDERBY_KEY;
      return $columns;
    }
    
    
    function get_terms_filter( $terms, $taxonomies, $args )
    {
        if ( (!is_array( $taxonomies ) && $taxonomies != $this->getTaxonomyName()) || (is_array( $taxonomies ) && !in_array( $this->getTaxonomyName() , $taxonomies)) || $args['orderby'] != self::ORDERBY_KEY ) return $terms;
        
        $empty = false;
        $ordered_terms = array();
        $unordered_terms = array();
    
        foreach ( $terms as $term ) {
            if ( is_object( $term ) ) {
                if ( $term_meta = get_option( $this->getSetOptionsKey( $term->term_id ) ) ) {
                    $term->tax_order = ( int ) $term_meta[ self::ORDERBY_KEY ];
                    $ordered_terms[] = $term;
                } else {
                    $term->tax_order = ( int ) 0;
                    $unordered_terms[] = $term;
                }
            } else {
                $empty = true;
            }
        }
            
        if ( ! $empty && count( $ordered_terms ) > 0)
            $this->tax_order_quickSort( $ordered_terms );
        else
            return $terms;
            
        if ( $args['order'] == 'desc' ) krsort( $ordered_terms ); // By default, the array is sorted ASC; sort DESC if needed
        
        return array_merge( $ordered_terms, $unordered_terms ); // Combine the newly ordered items with the unordered items and return
    }
    
    
    function tax_order_quickSort( &$array )
    {
        $cur = 1;
        $stack[1]['l'] = 0;
        $stack[1]['r'] = count($array)-1;
        
        do {
            $l = $stack[$cur]['l'];
            $r = $stack[$cur]['r'];
            $cur--;
            
            do {
                $i = $l;
                $j = $r;
                $tmp = $array[(int)( ($l+$r)/2 )];
                
                do {
                    while( $array[$i]->tax_order < $tmp->tax_order )
                        $i++;
                    while( $tmp->tax_order < $array[$j]->tax_order )
                        $j--;
                    
                    if( $i <= $j)
                    {
                        $w = $array[$i];
                        $array[$i] = $array[$j];
                        $array[$j] = $w;
                        
                        $i++;
                        $j--;
                    }
                }while( $i <= $j );
                
                if( $i < $r ) {
                    $cur++;
                    $stack[$cur]['l'] = $i;
                    $stack[$cur]['r'] = $r;
                }
                $r = $j;
            } while( $l < $r );
        } while( $cur != 0 );
    }
	
	function wp_get_object_terms( $terms, $object_ids, $taxonomies, $args ) {
		return $this->get_terms_filter( $terms, $taxonomies, $args );
	}
	
	function get_the_terms( $terms, $id, $taxonomy ) {
		$args = array( 'orderby' => self::ORDERBY_KEY , 'order' => 'asc');
        return $this->get_terms_filter( $terms, $taxonomy, $args);
    }
	
	function get_terms_orderby( $orderby, $args ) {
		if ( $orderby == self::ORDERBY_KEY )
			return '';
		else
			return $orderby;
	}
}

?>