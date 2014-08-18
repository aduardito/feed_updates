<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class DisplayData
{
    private $default_image;
    
    
    /**
     * fetch the content of the file
     */
    public function fetchContent()
    {
        try 
        {   
            $xml = file_get_contents('http://feeds.bbci.co.uk/news/technology/rss.xml');
            if ( $xml != FALSE )
            {
                $view = $this->processFileContent($xml);
            }
            else
            {
                throw new Exception( 'We could not fetch any data' );
            }
            
        } 
        catch (Exception $ex) 
        {
            $view = '<div id="error_message">' . $ex->getMessage() . '</div>';
        }
        
        return $view;
        
    }
    
    /**
     * 
     * @param string $xml content xml
     * @return string with xml
     * @throws Exception
     */
    private function processFileContent( $xml )
    {
        $view = null;
        
        $xml = simplexml_load_string($xml);
        
        if ( $xml instanceof SimpleXMLElement )
        {
            $view = $this->processXML($xml);
        }
        else
        {
            throw new Exception( 'The XML was not ready' );
        }
        
        return $view;
    }
    
    /**
     * starting to process 
     * @param SimpleXMLELement $xml 
     * @return string 
     */
    private function processXML($xml)
    {
        $headers = $this->createHeaders( $xml->channel );
        
        $items = $this->createItemContainer( $xml->channel->item );
        
        return $headers . $items;
        
    }
    
    
    /**
     * Create headers container and content to display 
     * @param  simplexmlelement $channel
     * @return string with header container and content
     */
    private function createHeaders( $channel )
    {
        $main_link = (string) $channel->link;
        $main_title = $this->createContainer( '<a href="'.$main_link.'">' .(string) $channel->title . '</a>', 'main_title');
        $main_description = $this->createContainer( (string) $channel->description, 'main_description');
        $main_image = (string) $channel->image->url ;
        
        
        $this->default_image = isset($channel->image->url) && 
            (string) $channel->image->url != null ? 
            (string) $channel->image->url : null;
        
        $headers = '<div id="feed_header">';
        $headers .= '<div class="feed_header_left"><img src="'.$main_image.'"/></div>';
        
        $headers .= '<div class="feed_header_right">' . 
                $main_title . $main_description .
                '</div>';
        
        $headers .= '<div style="clear:both;"></div>';
        $headers .= '</div>';
        
        return $headers;
    }
    
    
    /** 
     * Create Item container and sorted the items by title
     * @param simpleXMLElement array $items
     */
    private function createItemContainer( $items )
    {       
        $items_containers = '<div id="items_wrapper">';
        
        if ( count($items) > 0 )
        {
            $arrayItems_unsorted = array();
            
            foreach ($items as $key=>$value)
            {
                $this->createItemsContainer($value, $arrayItems_unsorted);   
            }
            
            if ( count($arrayItems_unsorted) > 0 )
            {
                if (ksort($arrayItems_unsorted))
                {
                    // array sorted
                    foreach ( $arrayItems_unsorted as $key=>$value )
                    {
                        //added the formated items to the blog
                        $items_containers .= $value;
                    }
                    
                }
            }
            else
            {
                
            }
        }
        else
        {
            $items_containers .= 'No results';
        }
        
        $items_containers .= '<div style="clear:both;"></div>';
        
        $items_containers .= '</div>';
        
        return $items_containers;
    }
    
    /**
     * create a div container to format the string
     * @param string $data string that the container will have
     * @param type $class
     * @return string
     */
    private function createContainer($data, $class)
    {
        $string = '<div class="' . $class . '" >';
        $string .= $data;
        $string .= '</div>';
        
        return $string;
    }
            
            
    /**
     * create the container for every item,
     * @param simpleXMLElement $value item data
     * @param array $arrayItems_unsorted will contain an unsorted array key=title value html view
     */
    private function createItemsContainer( $value, &$arrayItems_unsorted )
    {
        if ( $this->default_image == null )
        {
            $image = '<span>No Image</span>';
        }
        else
        {
            $image = '<img src="' . $this->default_image . '" />';
        }
        
        $itemContainer = '<div class="item_container">';
        $itemContainer .= $this->createContainer( 
            '<a href="' . (string) $value->link . '">' . (string) $value->title . '</a>',
            'item_title');
                
        $itemContainer .= '<div class="item_img">'. $image .'</div>';
        $itemContainer .= '<div class="item_content">';
        $itemContainer .= $this->createContainer((string) $value->pubDate, 'item_date');
        $itemContainer .= $this->createContainer((string) $value->description, 'item_desc');
        
        $itemContainer .= '</div>'; // item content
        
        $itemContainer .= '</div>'; // item container
        
        $arrayItems_unsorted[(string) $value->title] = $itemContainer;
        
    }
    
}