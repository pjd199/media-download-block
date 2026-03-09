import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { mediaURL, mediaTitle, mediaSize, fileLabel, customName } = attributes;
    if (!mediaURL) return null;

    return (
        <div {...useBlockProps.save({ className: 'wpdm-download-row' })} data-type={fileLabel}>
            <div className="wpdm-file-type-icon">{fileLabel}</div>
            <div className="wpdm-download-details">
                <div className="wpdm-download-title">{customName || mediaTitle}</div>
                <div className="wpdm-download-size">{mediaSize}</div>
            </div>
            <a href={mediaURL} className="wpdm-download-button" download>DOWNLOAD</a>
        </div>
    );
}
