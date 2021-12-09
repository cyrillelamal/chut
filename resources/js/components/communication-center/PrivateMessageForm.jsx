import React from "react";
import {Button, Form, Modal} from "react-bootstrap";

export default class PrivateMessageForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            body: '',
            submitted: false,
            valid: true,
        };
    }

    hide = (e = null) => {
        e && e.preventDefault() && e.stopPropagation();

        this.props.setUser && this.props.setUser(null);
    }

    handleSubmit = (e) => {
        e.preventDefault();

        if (this.state.body.length) {
            this.setState({submitted: true})
            this.props.send && this.props.send(this.state.body)
                .then(() => this.setState({body: '', submitted: false}));
            return;
        }

        this.setState({valid: false});
    }

    handleChange = (e) => {
        this.setState({body: e.target.value, valid: true});
    }

    render() {
        return (
            <Modal size="xl" centered backdrop="static" show={this.show} onHide={this.hide}>
                <Modal.Header closeButton>
                    {`Send private message to ${this.name}`}{/* TODO: i18n */}
                </Modal.Header>
                <Modal.Body>
                    <Form onSubmit={this.handleSubmit}>
                        <Form.Group>
                            <Form.Control
                                as="textarea"
                                placeholder={'Start typing'} // TODO: i18n
                                value={this.state.body}
                                onChange={this.handleChange}
                                className={this.valid ? '' : 'border border-danger'}
                            />
                        </Form.Group>
                    </Form>
                </Modal.Body>
                <Modal.Footer>
                    <Button variant="success" type="submit" onClick={this.handleSubmit} disabled={this.submitted}>
                        {'Send'}{/* TODO: i18n */}
                    </Button>
                </Modal.Footer>
            </Modal>
        );
    }

    get id() {
        return this.props.hasOwnProperty('id') ? this.props.id : this.email;
    }

    get name() {
        return this.props.hasOwnProperty('name') ? this.props.name : this.email;
    }

    get email() {
        return this.props.hasOwnProperty('email') ? this.props.email : '';
    }

    get show() {
        return this.props.show;
    }

    get submitted() {
        return this.state.submitted;
    }

    get valid() {
        return this.state.valid;
    }
}
