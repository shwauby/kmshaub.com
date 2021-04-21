/**
 * External dependencies
 */
import classnames from 'classnames/dedupe';

/**
 * WordPress dependencies
 */
const WPColorPicker = wp.components.ColorPicker;

const { Component } = wp.element;

const { __ } = wp.i18n;

const {
    Dropdown,
    Tooltip,
    BaseControl,
} = wp.components;

const {
    ColorPalette,
} = wp.blockEditor;

/**
 * Component Class
 */
export default class ColorPicker extends Component {
    constructor( ...args ) {
        super( ...args );

        // These states used to fix components re-rendering
        this.state = {
            keyForPalette: this.props.value,
            keyForPicker: this.props.value,
        };
    }

    render() {
        const {
            value,
            onChange,
            alpha = false,
            colorPalette = true,
            hint = __( 'Custom Color Picker', 'visual-portfolio' ),
            afterDropdownContent,
        } = this.props;

        return (
            <Dropdown
                className={ classnames( 'components-color-palette__item-wrapper components-circular-option-picker__option-wrapper', value ? '' : 'components-color-palette__custom-color' ) }
                contentClassName="components-color-palette__picker"
                renderToggle={ ( { isOpen, onToggle } ) => (
                    <Tooltip text={ hint }>
                        <button
                            type="button"
                            aria-expanded={ isOpen }
                            className="components-color-palette__item components-circular-option-picker__option"
                            onClick={ onToggle }
                            aria-label={ hint }
                            style={ { color: value || '' } }
                        >
                            <span className="components-color-palette__custom-color-gradient" />
                        </button>
                    </Tooltip>
                ) }
                renderContent={ () => (
                    <div className="vpf-component-color-picker">
                        <WPColorPicker
                            color={ value }
                            onChangeComplete={ ( color ) => {
                                let colorString;

                                if ( 'undefined' === typeof color.rgb || 1 === color.rgb.a ) {
                                    colorString = color.hex;
                                } else {
                                    const {
                                        r, g, b, a,
                                    } = color.rgb;
                                    colorString = `rgba(${ r }, ${ g }, ${ b }, ${ a })`;
                                }

                                onChange( colorString || '' );

                                this.setState( {
                                    keyForPalette: colorString,
                                } );
                            } }
                            disableAlpha={ ! alpha }
                            key={ this.state.keyForPicker }
                        />
                        { colorPalette ? (
                            <BaseControl
                                label={ __( 'Color Palette', 'visual-portfolio' ) }
                                className="vpf-component-color-picker-palette"
                            >
                                <ColorPalette
                                    value={ value }
                                    onChange={ ( color ) => {
                                        onChange( color || '' );

                                        this.setState( {
                                            keyForPicker: color,
                                        } );
                                    } }
                                    disableCustomColors
                                    key={ this.state.keyForPalette }
                                />
                            </BaseControl>
                        ) : '' }
                        { afterDropdownContent || '' }
                    </div>
                ) }
            />
        );
    }
}
