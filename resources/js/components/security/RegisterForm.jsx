import React from "react";
import {Button, Form} from "react-bootstrap";
import {login, register} from "../../services/security";
import {UserContext} from "./UserContext";
import {withTranslation} from "react-i18next";

class RegisterForm extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            name: '',
            email: '',
            password: '',
            submitted: false,
            errors: {},
        };
    }

    handleSubmit = (e) => {
        e.preventDefault();
        this.setState({submitted: true});

        const {name, email, password} = this.state;

        register({name, email, password})
            .then(() => login({email, password}))
            .then(this.context.setUser)
            .catch(({response}) => {
                const {data} = response;
                const {errors} = data;
                this.setState({submitted: false, errors})
            });
    }

    handleChange = ({target}) => {
        const {name, value} = target;
        this.setState({[name]: value});
    }

    render() {
        const {t} = this.props;

        return (
            <Form className="p-4 p-md-5 border rounded-3 bg-light" onSubmit={this.handleSubmit}>

                <Form.Group className="form-floating mb-3">
                    <Form.Control
                        type="text"
                        placeholder={t('security.form.name')}
                        name="name"
                        value={this.state.name}
                        onChange={this.handleChange}
                        disabled={this.state.submitted}
                    />
                    <Form.Label>{t('security.form.name')}</Form.Label>
                    {this.state.errors.name && this.state.errors.name.map(error => (
                        <Form.Text key={error}>{error}</Form.Text>
                    ))}
                </Form.Group>

                <Form.Group className="form-floating mb-3">
                    <Form.Control
                        type="email"
                        placeholder={'your@mail.com'}
                        name="email"
                        value={this.state.email}
                        onChange={this.handleChange}
                        disabled={this.state.submitted}
                    />
                    <Form.Label>{t('security.form.email')}</Form.Label>
                    {this.state.errors.email && this.state.errors.email.map(error => (
                        <Form.Text key={error}>{error}</Form.Text>
                    ))}
                </Form.Group>

                <Form.Group className="form-floating mb-3">
                    <Form.Control
                        type="password"
                        placeholder={t('security.form.password')}
                        name="password"
                        value={this.state.password}
                        onChange={this.handleChange}
                        disabled={this.state.submitted}
                    />
                    <Form.Label>{t('security.form.password')}</Form.Label>
                    {this.state.errors.password && this.state.errors.password.map(error => (
                        <Form.Text key={error}>{error}</Form.Text>
                    ))}
                </Form.Group>

                <Button variant="primary" className="w-100 btn-lg" type="submit" disabled={this.state.submitted}>
                    {t('security.register')}
                </Button>

                <hr className="my-4"/>
                <small className="text-muted">{t('app.disclaimer')}</small>
            </Form>
        );
    }
}

RegisterForm.contextType = UserContext;

export default withTranslation()(RegisterForm);
