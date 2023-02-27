import { Controller } from '@hotwired/stimulus';
import { Modal } from 'bootstrap';
import $ from 'jquery';

export default class extends Controller {
    static targets = ['modal', 'modalBody'];
    static values = {
        formUrl: "/clients_modal_form/10/edit",
    }
    async openModal(event) {
        
        const modal = new Modal(this.modalTarget);
        modal.show();
        this.modalBodyTarget.innerHTML = await $.ajax(this.formUrlValue);
    }
    
}