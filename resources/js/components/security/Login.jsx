import React from "react";
import Anonymous from "./Anonymous";
import Header from "../common/Header";
import {Link} from "react-router-dom";
import LoginForm from "./LoginForm";
import {withTranslation} from "react-i18next";

class Login extends React.Component {
    render() {
        const {t} = this.props;

        return (
            <Anonymous>
                <div className="container py-4">

                    <Header/>

                    <div className="row align-items-center g-lg-5 py-5">

                        <div className="col-md-10 mx-auto col-lg-5">
                            <h1 className="mb-3 text-center">
                                {t('security.login')}
                            </h1>
                            <LoginForm/>
                            <p className="mt-2 text-center">
                                <Link to="/register">
                                    {t('security.or_register')}
                                </Link>
                            </p>
                        </div>

                    </div>
                </div>
            </Anonymous>
        );
    }
}

export default withTranslation()(Login);
