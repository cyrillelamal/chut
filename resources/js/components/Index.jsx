import React from "react";
import {Link} from "react-router-dom";
import Anonymous from "./security/Anonymous";
import Header from "./common/Header";
import {withTranslation} from "react-i18next";

class Index extends React.Component {
    render() {
        const {t} = this.props;

        return (
            <Anonymous>
                <div className="container py-4">

                    <Header/>

                    <div className="p-5 mb-4 bg-light rounded-3">
                        <div className="container-fluid py-5">
                            <h1 className="display-5 fw-bold">{t('app.name')}</h1>
                            <p className="col-md-8 fs-4">
                                {t('app.description')}
                            </p>
                            <div className="d-flex flex-row justify-content-start">
                                <div className="">
                                    <Link to="/login" className="btn btn-outline-secondary">
                                        {t('security.login')}
                                    </Link>
                                </div>
                                <div className="ps-2">
                                    <Link to="/register" className="btn btn-outline-primary mr-3">
                                        {t('security.register')}
                                    </Link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </Anonymous>
        );
    }
}

export default withTranslation()(Index);
