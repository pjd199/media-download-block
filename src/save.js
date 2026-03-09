import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { files, headerText } = attributes;

    if (!files || files.length === 0) return null;

    return (
        <div {...useBlockProps.save({ className: 'mdb-download-container' })}>
            <h3 className="mdb-download-header">{headerText}</h3>
            {files.map((file, index) => (
                <div key={index} className="mdb-download-row">
                    <div className="mdb-file-type-icon">{file.fileLabel}</div>
                    <div className="mdb-download-details">
                        <div className="mdb-download-title">{file.displayName}</div>
                        <div className="mdb-download-size">{file.fileSize}</div>
                    </div>
                    <a href={file.url} className="mdb-download-button" download>
                        DOWNLOAD
                    </a>
                </div>
            ))}
        </div>
    );
}