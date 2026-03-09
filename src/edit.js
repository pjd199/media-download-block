import { useBlockProps, MediaUpload, MediaUploadCheck, InspectorControls } from '@wordpress/block-editor';
import { Button, TextControl, PanelBody, SelectControl, ToggleControl } from '@wordpress/components';
import { __ } from '@wordpress/i18n';
import { getFileIcon } from './utils';

export default function Edit({ attributes, setAttributes }) {
    const { 
        files, 
        headerText, 
        headerLevel, 
        layoutStyle, 
        showDownloadAll 
    } = attributes;

    const onSelectFiles = (mediaItems) => {
        const newFiles = mediaItems.map(media => ({
            id: media.id,
            url: media.url,
            realFileName: media.filename,
            displayName: media.title,
            fileSize: media.filesizeHumanReadable,
            fileLabel: media.url.split('.').pop().toUpperCase().substring(0, 4)
        }));
        setAttributes({ files: [...files, ...newFiles] });
    };

    const moveFile = (oldIndex, newIndex) => {
        if (newIndex < 0 || newIndex >= files.length) return;
        const updatedFiles = [...files];
        const [movedItem] = updatedFiles.splice(oldIndex, 1);
        updatedFiles.splice(newIndex, 0, movedItem);
        setAttributes({ files: updatedFiles });
    };

    const updateFileTitle = (newName, index) => {
        const updatedFiles = [...files];
        updatedFiles[index].displayName = newName;
        setAttributes({ files: updatedFiles });
    };

    return (
        <>
            <InspectorControls>
                <PanelBody title={__('Display Settings', 'mdb')}>
                    <SelectControl
                        label={__('Display Style', 'mdb')}
                        value={layoutStyle}
                        options={[
                            { label: __('Standard Row', 'mdb'), value: 'row' },
                            { label: __('Compact List', 'mdb'), value: 'compact' },
                        ]}
                        onChange={(val) => setAttributes({ layoutStyle: val })}
                    />
                    <SelectControl
                        label={__('Header Level', 'mdb')}
                        value={headerLevel}
                        options={[
                            { label: 'H1', value: 1 },
                            { label: 'H2', value: 2 },
                            { label: 'H3', value: 3 },
                            { label: 'H4', value: 4 },
                        ]}
                        onChange={(val) => setAttributes({ headerLevel: parseInt(val) })}
                    />
                    <ToggleControl
                        label={__('Show "Download All" Button', 'mdb')}
                        checked={showDownloadAll}
                        onChange={(val) => setAttributes({ showDownloadAll: val })}
                    />
                </PanelBody>
            </InspectorControls>

            <div {...useBlockProps({ className: `mdb-editor-wrapper mdb-style-${layoutStyle}` })}>
                <TextControl
                    label={__('Block Header', 'mdb')}
                    value={headerText}
                    onChange={(val) => setAttributes({ headerText: val })}
                />

                <div className="mdb-files-list">
                    {files.map((file, index) => (
                        <div key={index} className="mdb-download-row mdb-editor-row">
                            <div className="mdb-editor-controls">
                                <Button icon="arrow-up-alt2" onClick={() => moveFile(index, index - 1)} disabled={index === 0} />
                                <Button icon="arrow-down-alt2" onClick={() => moveFile(index, index + 1)} disabled={index === files.length - 1} />
                            </div>
                            <div className="mdb-file-type-icon">
                                {getFileIcon(file.fileLabel)}
                            </div>
                            <div className="mdb-download-details">
                                <TextControl
                                    value={file.displayName}
                                    onChange={(val) => updateFileTitle(val, index)}
                                    help={`${__('Source:', 'mdb')} ${file.realFileName} (${file.fileSize})`}
                                />
                            </div>
                            <Button isDestructive icon="trash" onClick={() => setAttributes({ files: files.filter((_, i) => i !== index) })} />
                        </div>
                    ))}
                </div>

                <MediaUploadCheck>
                    <MediaUpload
                        onSelect={onSelectFiles}
                        multiple={true}
                        render={({ open }) => (
                            <Button variant="secondary" onClick={open} className="mdb-add-btn">{__('Add Files', 'mdb')}</Button>
                        )}
                    />
                </MediaUploadCheck>
            </div>
        </>
    );
}