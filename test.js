mport React from 'react';
import 'react-dropzone-uploader/dist/styles.css'
import Dropzone from 'react-dropzone-uploader'
import { getDroppedOrSelectedFiles } from 'html5-file-selector'
import Axios from 'axios';

const FileUploadComponent = () => {

    //store multiple files in this state
    const [files, setFiles] = React.useState([])
    const [folder, setFolder] = React.useState(1);
   // console.log(files);

    //get upload params for dropzone component

    //get files
    const fileParams = ({ meta }) => {
        return { url: 'https://httpbin.org/post' }
    }
    const onFileChange = ({ meta, file }, status) => {
       // console.log(status, meta, file)
        //store files in state where status is done


    }
    const onSubmit = (files, allFiles) => {
      //  console.log(files.map(f => f.meta))
        allFiles.forEach(f => f.remove())
        //store in state files unremoved files
        setFiles(files.map(f => f.meta));
        handleSubmit({preventDefault: () => {}});

    }

    const handleSubmit = (e) => {
        e.preventDefault();
        const formData = new FormData();
        formData.append('folder', folder);
        files.forEach(file => {
            formData.append('files[]', file.file);
        });
        //alert to form data
        alert(formData);
        Axios.post('http://127.0.0.1:8000/api/store-file', formData, {
            headers: {
                'Content-Type': 'multipart/form-data',
                'Accept': 'application/json',
                'Authorization': 'Bearer ' + localStorage.getItem('token')
             }
        }).then(res => {
            console.log(res);
        }).catch(err => {
            console.log(err);
        })
    }

    const getFilesFromEvent = e => {
        return new Promise(resolve => {
            getDroppedOrSelectedFiles(e).then(chosenFiles => {
                resolve(chosenFiles.map(f => f.fileObject))
                setFiles(chosenFiles);
            })
        })

    }
    const selectFileInput = ({ accept, onFiles, files, getFilesFromEvent }) => {
        const textMsg = files.length > 0 ? 'Upload Again' : 'Select Files'
        return (
            <label className="btn btn-danger mt-4">
                {textMsg}
                <input
                    style={{ display: 'none' }}
                    type="file"
                    accept={accept}
                    multiple
                    onChange={e => {
                        getFilesFromEvent(e).then(chosenFiles => {
                            onFiles(chosenFiles)
                        })
                    }}
                />
            </label>
        )
    }
    return (

        <Dropzone
            onSubmit={onSubmit}
            onChangeStatus={onFileChange}
            InputComponent={selectFileInput}
            getUploadParams={fileParams}
            getFilesFromEvent={getFilesFromEvent}
            //add pdf and docx file types to accept
            accept="image/,application/,video/*"
            maxFiles={5}
            inputContent="Drop A File"
            //how to disable submit button when no files are selected
            submitButtonDisabled={files => files.length < 1}
            // SubmitButton={null}
            styles={{
                dropzone: { width: 600, height: 400 },
                dropzoneActive: { borderColor: 'green' },
            }}
        />
    );
};
export default FileUploadComponent