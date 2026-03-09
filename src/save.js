import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { mediaURL, mediaTitle, mediaSize, fileLabel, customName } = attributes;
    
    if (!mediaURL) return null;

    return (
        <div {...useBlockProps.save({ className: 'mdb-download-row' })}>
            <div className="mdb-file-type-icon">{fileLabel}</div>
            <div className="mdb-download-details">
                <div className="mdb-download-title">{customName || mediaTitle}</div>
                <div className="mdb-download-size">{mediaSize}</div>
            </div>
            <a href={mediaURL} className="mdb-download-button" download>
                DOWNLOAD
            </a>
        </div>
    );
}