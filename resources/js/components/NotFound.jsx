import React from "react";
import {Link} from "react-router-dom";
import {withTranslation} from "react-i18next";

class NotFound extends React.Component {
    render() {
        const {t} = this.props;

        return (
            <div className="px-4 py-5 my-5 text-center">
                <h1 className="display-5 fw-bold">
                    {t('not_found')}
                </h1>
                <div className="col-lg-6 mx-auto mt-5">
                    <div className="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <Link to="/" className="btn btn-primary btn-lg px-4">
                            {t('home')}
                        </Link>
                    </div>
                </div>
            </div>
        );
    }
}

export default withTranslation()(NotFound);
