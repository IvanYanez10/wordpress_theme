
import React from "react";
import { Form, ListGroup, Modal, Badge } from "react-bootstrap";
import { __ } from '@wordpress/i18n';
import PerfectScrollbar from 'react-perfect-scrollbar'
import 'react-perfect-scrollbar/dist/css/styles.css';

var searchInControlsAllResults,
    Preset = 0,
    Offset = 30;

const SearchBoxModal = ( { ...props } ) => {


    const [ searchResults, setsearchResults ] = React.useState( '' );

    const switchThemeMode = () => {

        subetuwebCustomizerSearchOptions.darkMode = subetuwebCustomizerSearchOptions.darkMode === '1'
        || subetuwebCustomizerSearchOptions.darkMode === 'true'
        || subetuwebCustomizerSearchOptions.darkMode === true ? false : true;
        jQuery( '.modal-dialog.subetuweb-customize-search-modal' ).toggleClass( 'light-theme' );

        wp.ajax.post( 'subetuweb_update_search_box_light_mode', {
            darkMode: subetuwebCustomizerSearchOptions.darkMode
        } );
    }

    /**
     * Hide the Finder &
     * Expand Customize Sections When Click on Each Item
     *
     * @param {string} sectionName
     * @param {string} ElementID
     */
    const ClickHandler = ( sectionName, ElementID ) => {
        const section = wp.customize.section( sectionName );
        section.expand();
        setsearchResults( '' );
        jQuery( '.subetuweb-customize-search-modal' ).parent().fadeOut();
        jQuery( '.modal-backdrop.show' ).removeClass( 'show' );
        props.onHide();

        setTimeout( function() {
            jQuery( '.subetuweb-customize-search-modal .modal-header button.close' ).trigger( 'click' ).trigger( 'mouseup' )
            if ( jQuery( '#customize-control-' + ElementID ).length ) {

                jQuery( '#customize-controls .wp-full-overlay-sidebar-content' ).scrollTop(0);

                jQuery( '#customize-controls .wp-full-overlay-sidebar-content' ).animate(
                    { scrollTop: jQuery( '#customize-control-' + ElementID ).offset().top - 50 }
                , "slow" );

                jQuery( '#customize-control-' + ElementID ).addClass( 'subetuweb-control-focused' );
            }
        }, 1500 )

        setTimeout( () => {
            jQuery( '.subetuweb-control-focused' ).removeClass( 'subetuweb-control-focused' );
        }, 8000 );
    }

    const createList = ( searchInControlsResults ) => {
        /**
         * Prepare View From Search Result
         */
         var list = searchInControlsResults.map( function( data, index ) {

            if ( ! data.label || typeof data.panelName === 'undefined' ) {
                return;
            }

            return <ListGroup.Item
                key          = { index }
                id           = { `accordion-section-${data.section}` }
                className    = "accordion-section control-section control-section-default"
                aria-owns    = { `sub-accordion-section-${data.section}` }
                onClick      = { () => { ClickHandler( data.section, data.settings.default ) } }
                action>

                <Badge className="btn-primary">
                    { data.panelName }
                    { data.sectionName ? <span className="dashicons dashicons-arrow-right-alt2"></span> : '' }
                    { data.sectionName ? data.sectionName : '' }
                </Badge>

                <span>{ String(data.label) }</span>

                <span className="dashicons dashicons-editor-break"></span>

            </ListGroup.Item>
        });

        return list;
    }

    const showMore = () => {
        if ( Offset >= 211 ) {
            return false;
        }

        Offset = Offset + 30;
        var searchInControlsResults = searchInControlsAllResults.slice( Preset, Offset );

        if ( ! searchInControlsResults.length ) {
            return false;
        }

        var list = createList( searchInControlsResults );

        setsearchResults( list );
    }

    /**
     * Search Handler
     *
     * @param {element} e
     * @returns
     */
    const onSearch = ( e ) => {
        var search = e.target.value;
        searchInControlsAllResults  = props.SearchHandler.searchInControls( search );
        Offset = 30
        var searchInControlsResults = searchInControlsAllResults.slice( Preset, Offset );
        setsearchResults( '' );

        if ( ! searchInControlsResults.length ) {
            return false;
        }

        var list = createList( searchInControlsResults );

        setsearchResults( list );
    }

    return <>
        <Modal
            size   = "lg"
            show   = { props.show }
            onHide = { props.onHide }
            dialogClassName = {
                subetuwebCustomizerSearchOptions.darkMode === '1'
                || subetuwebCustomizerSearchOptions.darkMode === 'true'
                || subetuwebCustomizerSearchOptions.darkMode === true ? "subetuweb-customize-search-modal" : "subetuweb-customize-search-modal light-theme" }
            aria-labelledby = "contained-modal-title-vcenter"
            centered>
            <Modal.Header closeButton>
                <Form.Group className="full-width" controlId="subetuweb-wp-customize-search-input">
                    <i className="dashicons dashicons-search"></i>
                    <Form.Control type="text" placeholder={ __( "Search..." ) } onChange={ onSearch } />
                    <span onClick={ switchThemeMode } className="dashicons dashicons-lightbulb"></span>
                </Form.Group>
            </Modal.Header>
            <Modal.Body>
            { searchResults ?
                    <PerfectScrollbar
                        onYReachEnd = { showMore }
                    >
                        <ListGroup>
                            { searchResults }
                        </ListGroup>
                    </PerfectScrollbar>
            : ""}
            </Modal.Body>
        </Modal>
    </>
}

export default SearchBoxModal;