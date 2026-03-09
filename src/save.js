import { useBlockProps } from '@wordpress/block-editor';

export default function save({ attributes }) {
    const { files, headerText, layoutStyle } = attributes;
    if (!files || files.length === 0) return null;

    return (
        <div {...useBlockProps.save({ className: `mdb-container mdb-style-${layoutStyle}` })}>
            {headerText && <h3 className="mdb-front-header">{headerText}</h3>}
            <div className="mdb-list-wrapper">
                {files.map((file, index) => (
                    <div key={file.id || index} className="mdb-download-row">
                        <div className="mdb-file-type-icon">{file.fileLabel}</div>
                        <div className="mdb-download-details">
                            <div className="mdb-download-title">{file.displayName}</div>
                            <div className="mdb-download-size">{file.fileSize}</div>
                        </div>
                        <a href={file.url} className="mdb-download-button" download>{'DOWNLOAD'}</a>
                    </div>
                ))}
            </div>
        </div>
    );
}