/* Demo Note:  This demo uses a FileProgress class that handles the UI for displaying the file name and percent complete.
The FileProgress class is not part of SWFUpload.
*/


/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function fileQueued(file) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("Ожидание...");
		progress.toggleCancel(true, this);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileQueueError(file, errorCode, message) {
	try {
		if (errorCode === SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED) {
			alert("Вы выбрали слишком много файлов.\n" + (message === 0 ? "Вы достигли лимита на загрузку файлов." : "Вы должны выбрать " + (message > 1 ? "не более " + message + " файлов." : "один файл.")));
			return;
		}

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
			progress.setStatus("Файл слишком большой.");
			this.debug("Код ошибки: Файл слишком большой, название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
			progress.setStatus("Нельзя загружать пустые файлы.");
			this.debug("Код ошибки: Нельзя загружать пустые файлы, название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
			progress.setStatus("Неверный формат файла.");
			this.debug("Код ошибки: Неверный формат файла, название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		default:
			if (file !== null) {
				progress.setStatus("Неопознанная ошибка");
			}
			this.debug("Код ошибки: " + errorCode + ", название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesSelected > 0) {
			document.getElementById(this.customSettings.cancelButtonId).disabled = false;
		}
		
		/* I want auto start the upload and I can do that here */
		this.startUpload();
	} catch (ex)  {
        this.debug(ex);
	}
}

function uploadStart(file) {
	try {
		/* I don't want to do any file validation or anything,  I'll just update the UI and
		return true to indicate that the upload should start.
		It's important to update the UI here because in Linux no uploadProgress events are called. The best
		we can do is say we are uploading.
		 */
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setStatus("Загрузка...");
		progress.toggleCancel(true, this);
	}
	catch (ex) {}
	
	return true;
}

function uploadProgress(file, bytesLoaded, bytesTotal) {
	try {
		var percent = Math.ceil((bytesLoaded / bytesTotal) * 100);

		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setProgress(percent);
		progress.setStatus("Загрузка...");
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	try {
		var result = jQuery.parseJSON(serverData), progress = new FileProgress(file, this.customSettings.progressTarget), row = '';
		if (result.success) {
			progress.setComplete();
			progress.setStatus("Завершено.");
			row = '<div class="row"><div class="item_div"><img alt="" src="' + result.src + '"></div><div class="item_div col210"><label class="caption" for="UsedTyrePhotoFile' + result.id + '"><acronym title="Файл">Файл</acronym></label><input type="file" id="UsedTyrePhotoFile' + result.id + '" name="data[UsedTyrePhoto][file][' + result.id + ']"></div><div class="item_div rm-link"><a onclick="delete_row(this);" class="no-loader" href="javascript:void(0);">удалить</a></div></div>';
			$('#divSWFUploadUI').before(row);
			$('#UsedTyrePhotoIds').val($('#UsedTyrePhotoIds').val() + ',' + result.id);
		}
		else {
			progress.setError();
			progress.setStatus(result.error);
		}
		progress.toggleCancel(false);

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	try {
		var progress = new FileProgress(file, this.customSettings.progressTarget);
		progress.setError();
		progress.toggleCancel(false);

		switch (errorCode) {
		case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
			progress.setStatus("Ошибка загрузки: " + message);
			this.debug("Код ошибки: HTTP-ошибка, название файла: " + file.name + ", сообщение: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
			progress.setStatus("Загрузка не удалась.");
			this.debug("Код ошибки: Загрузка не удалась, название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.IO_ERROR:
			progress.setStatus("Ошибка ввода-вывода сервера");
			this.debug("Код ошибки: Ошибка ввода-вывода, название файла: " + file.name + ", сообщение: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
			progress.setStatus("Ошибка безопасности");
			this.debug("Код ошибки: Ошибка безопасности, название файла: " + file.name + ", сообщение: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
			progress.setStatus("Достигнут лимит на загрузку.");
			this.debug("Код ошибки: Достигнут лимит на загрузку, название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_VALIDATION_FAILED:
			progress.setStatus("Проверка не пройдена. Загрузка отменена.");
			this.debug("Код ошибки: Проверка не пройдена, название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			// If there aren't any files left (they were all cancelled) disable the cancel button
			if (this.getStats().files_queued === 0) {
				document.getElementById(this.customSettings.cancelButtonId).disabled = true;
			}
			progress.setStatus("Отменено");
			progress.setCancelled();
			break;
		case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
			progress.setStatus("Остановлено");
			break;
		default:
			progress.setStatus("Неопознання ошибка: " + errorCode);
			this.debug("Код ошибки: " + errorCode + ", название файла: " + file.name + ", размер файла: " + file.size + ", сообщение: " + message);
			break;
		}
	} catch (ex) {
        this.debug(ex);
    }
}

function uploadComplete(file) {
	if (this.getStats().files_queued === 0) {
		document.getElementById(this.customSettings.cancelButtonId).disabled = true;
	}
}

// This event comes from the Queue Plugin
function queueComplete(numFilesUploaded) {
	var status = document.getElementById("divStatus");
	status.innerHTML = 'Загружено файлов: ' + numFilesUploaded;
}
