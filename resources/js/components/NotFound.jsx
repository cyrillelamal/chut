import React from "react";
import {Link} from "react-router-dom";

export default class NotFound extends React.Component {
    render() {
        return (
            <div className="px-4 py-5 my-5 text-center">
                <h1 className="display-5 fw-bold">
                    {'The page you are looking for does not exist'}{/* TODO: i18n */}
                </h1>
                <div className="col-lg-6 mx-auto mt-5">
                    <div className="d-grid gap-2 d-sm-flex justify-content-sm-center">
                        <Link to="/" className="btn btn-primary btn-lg px-4">
                            {'Go to the home page'}{/* TODO: i18n */}
                        </Link>
                    </div>
                </div>
            </div>
        );
    }
}
