FORMAT: 1A
HOST: thenetwork.fusecourse.com/api/

# TheNetwork

TheNetwork is a simple social network api that allows users to add new posts, follow each other and likes each other posts

## Authorization [/login]

### login [POST]

+ Request (application/json)

    + Attributes
        + email (string) - user email
        + password (string) - user password

    + Body

            {
                "email": "manssour.mohammed@gmail.com",
                "password" : "secret"
            }


+ Response 401 (application/json)

        {
            "meta": {
                "code": 0,
                "message": ["Not Authorized"]
            }
        }

+ Response 412 (application/json)

        {
            "meta": {
                "code": 0,
                "message": ["Your account is not confirmed"]
            }
        }

+ Response 200 (application/json)

    + schema

            {
                "$schema": "http://json-schema.org/draft-04/schema#",
                "type": "object",
                "properties": {
                    "data": {
                        "$schema": "http://json-schema.org/draft-04/schema#",
                        "type": "object",
                        "properties" : {
                            "id" : {
                                "type": "integer",
                                "description" : "user id"
                            },
                            "name" : {
                                "type" : "string",
                                "description" : "user name"
                            },
                            "email" : {
                                "type" : "string",
                                "description" : "user email"
                            },
                            "description" : {
                                "type" : "string",
                                "description" : "user description, can be null"
                            },
                            "followers_count" : {
                                "type" : "integer",
                                "description" : "number of users who are following current user"
                            },
                            "following_count" : {
                                "type" : "integer",
                                "description" : "number of users who are being followed by current user"
                            },
                            "profile_picture" : {
                                "type" : "integer",
                                "description" : "id of profile picture, please refer to files section"
                            },
                            "cover" : {
                                "type": "integer",
                                "description" : "id of cover photo, please refer to files section"
                            }
                        }
                    }
                }
            }

    + Body

            {
                "data": {
                    "id" : 1,
                    "name" : "Mohammed Manssour",
                    "email" : "manssour.mohammed@gmail.com",
                    "description" : "Senior Software Engineer",
                    "followers_count" : 100,
                    "following_count" : 200,
                    "profile_picture" : 1,
                    "cover" : 2
                },
                "meta": {
                    "code": 1,
                    "message": "success"
                    "token" : "example_token"
                }
            }

### Registration  [POST /register]
+ Request (application/json)

    + Attributes
        + name (string) - (required) - user name
        + email (string)  - (required) - user email
        + password (string) - (require) user password
        + password_confirmation (string) - (require) - passowrd confirmation
        + description (string) - user about you feild

    + Body

            {
                "name": "Mohammed Manssour",
                "email": "manssour.mohammed@gmail.com",
                "password" : "secret",
                "password_confirmation" : "secret",
                "description": "Senior Software Engineer"
            }

+ Response 422 (application/json)

        {
            "meta" : {
                "code" : 0,
                "message" : ["errors array"]
            }
        }

+ Response 200 (application/json)

        {
            "meta" : {
                "code" : 1,
                "message" : "success"
            }
        }

## Current User [/me]

### get current user info [GET]
+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200 (application/json)

        {
            "data" : {
                "id" : 1,
                "name" : "Mohammed Manssour",
                "email" : "manssour.mohammed@gmail.com",
                "description" : "Senior Software Engineer",
                "followers_count" : 100,
                "following_count" : 200,
                "profile_picture" : 1,
                "cover" : 2
            },
            "meta" : {
                "code": 1,
                "message" : "success"
            }
        }

### update current user info [PUT]
+ Request (application/json)

    + Headers

            Authorization: "Bearer {token}"

    + Attributes

        + name (string) - (required) - user name
        + email (string)  - (required) - user email
        + password (string) - (optional) user password
        + password_confirmation (string) - (required if password was provided) - passowrd confirmation
        + description (string) - user about you feild
        + profile_picture (string) - (optional) - user profile picture - file id, please refer to files section
        + cover (string) - (optional) - user cover photo - file id, please refer to files section

    + Body

            {
                "name" : "Mohammed Manssour",
                "email" : "manssour.mohammed@gmail.com",
                "description" : "Senior Software Engineer",
                "profile_picture" : 2,
                "cover" : 3
            }

+ Response 422 (application/json)

    + Attributes (ValidationError)

+ Response 200 (application/json)

    + Attributes (successMeta)



## Group Followers & Following [/users/{user}/followers?page={page}]

### list of all followers [GET]
meta will vary depending on data count if data count is 0 then meta will be a failure meta
and if data count is greater than 1 meta will be success meta

+ parameters
    + user: `1` (number) - user id
    + page: `1` (number) - (optional) pagination parameter, when set to 2 it will skip first 20 posts

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200 (application/json)

    + Attributes
        + data (array[user])
        + meta (successContentWithPagination)

### list of all following [GET /users/{user}/following?page={page}]
meta will vary depending on data count if data count is 0 then meta will be a failure meta
and if data count is greater than 1 meta will be success meta

+ parameters
    + user: `1` (number) - user id
    + page: `1` (number) - (optional) pagination parameter, when set to 2 it will skip first 20 posts

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200 (application/json)

    + Attributes
        + data (array[user])
        + meta (successContentWithPagination)

### follow user [POST /users/{user}/followers]
this endpoit will return 404 if user was not found
it will return 409 if current user already follow wanted user

+ parameters
    + user: `1` (number) - user id to follow

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 404 (application/json)

    + Attributes
        + meta (four04content)

+ Response 409 (application/json)

    + Attributes
        + meta (four09content)

+ Response 200 (application/json)

    + Attributes
        + meta (successContent)


### unfollow user [DELETE /users/{user}/followers]
this endpoit will return 404 if user was not found
it will return 409 if current user not following wanted user

+ parameters
    + user: `1` (number) - (required) user id to unfollow

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 404 (application/json)

    + Attributes
        + meta (four04content)

+ Response 409 (application/json)

    + Attributes
        + meta (four09content)

+ Response 200 (application/json)

    + Attributes
        + meta (successContent)


## Posts [/posts?source={source}&user={user}&page={page}&trendy={trendy}]

### list of all posts [GET]
+ parameters
    + source: `feed` (string) - (optional) getting posts from feed or user posts when set to `user`
    + user: `1` (number) - (optional) user to get posts from, you need to set source to user when using this parameter
    + page: `1` (number) - (optional) pagination parameter, when set to 2 it will skip first 20 posts
    + trendy: `true` (boolean) - (optional) it will get trendy posts when to set to true

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200

    + Attributes
        + data (array[post])
        + meta (successContentWithPagination)

### create new post [POST]

+ Request

    + Headers

            Authorization: "Bearer {token}"

    + Attributes
        + content: `This is post content` (string) - post content
        + images: `[1, 2, 3]` (array) - list of images

+ Response 422

    + Attributes (ValidationError)

+ Response 200

    + Attributes
        + data (post)
        + meta (successContent)

### update post [PUT /posts/{post}]

+ parameters
    + post: `id` (number) - post id

+ Request

    + Headers

            Authorization: "Bearer {token}"

    + Attributes
        + content: `This is post content` (string) - post content
        + images: `[1, 2, 3]` (array) - list of images

+ Response 422

    + Attributes (ValidationError)

+ Response 200

    + Attributes
        + data (post)
        + meta (successContent)

### delete post [DELETE /posts/{post}]

+ parameters
    + post: `id` (number) - post id

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200

    + Attributes (successMeta)

## Comments [/posts/{post}/comments?page={page}]

### list of all comments [GET]

+ parameters
    + post: `1` (number) - post
    + page: `1` (number) - pagination parameter

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200

    + Attributes
        + data (array[comment])
        + meta (successContentWithPagination)

### create comment [POST /posts/{post}/comments]

+ parameters
    + post: `1` (number) - post

+ Request

    + Headers

            Authorization: "Bearer {token}"

    + Attributes
        + content: `This is comment content` (string) - comment content

+ Response 422
    + Attributes (ValidationError)

+ Response 200
    + Attributes
        + data (comment)
        + meta (successContent)

### update comment [PUT /posts/{post}/comments/{comment}]

+ parameters
    + post: `1` (number) - post
    + comment: `1` (number) - comment id

+ Request

    + Headers

            Authorization: "Bearer {token}"

    + Attributes
        + content: `This is comment content` (string) - comment content

+ Response 422
    + Attributes (ValidationError)

+ Response 200
    + Attributes
        + data (comment)
        + meta (successContent)

### delete comment [DELETE /posts/{post}/comments/{comment}]

+ parameters
    + post: `1` (number) - post
    + comment: `1` (number) - comment id

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200
    + Attributes (successMeta)

## Likes [/posts/{post}/likes]

### list of people who likes a post [GET]

+ parameters
    + post: `1` (number) - post

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200

    + Attributes
        + data (array[simpleUser])
        + meta (successContentWithPagination)

### like a post [POST]

+ parameters
    + post: `1` (number) - post

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200

    + Attributes (successMeta)

### unlike a post [DELETE]

+ parameters
    + post: `1` (number) - post

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200

    + Attributes (successMeta)


## Group Files [/files]

This section handles uploading and getting files for you

### Uploading Files [POST /files/upload]

+ Request (multipart/form-data, boundary=AaB03x)

    + Headers

            Authorization: "Bearer {token}"

    + Attributes

        + file - file to upload

+ Response 200 (application/json)

    + Attributes
        + data (object)
            + id : `1` (number)

        + meta (successContent)


### Getting a file [GET /files/{id}]

+ parameters
    + id: `files id` (number) - file id

+ Request

    + Headers

            Authorization: "Bearer {token}"

+ Response 200

        server will stream wanted file to client

## Data Structures

### user
+ id: `1` (number) - user id
+ name: `Mohammed Manssour` (string) - user name
+ followers_count: `100` (number) - user followers count
+ following_count: `200` (number) - user following count
+ description: `Senior Software Engineer` (string) - user description
+ profile_picture: `1` (number) - user profile picture, file id
+ cover: `2` (number) - user cover photo, file id

### simpleUser
+ id: `1` (number) - user id
+ name: `Mohammed Manssour` (string) - user name
+ profile_picture: `1` (number) - user profile picture, file id

### post
+ id: `1` (number) - post id
+ content: `This is post content` (string) - post content
+ user (object) - post owner
    + data (simpleUser)
+ images (array) - list of images ids

### comment
+ id: `1` (number) - post id
+ content: `This is post content` (string) - post content
+ user (object) - post owner
    + data (simpleUser)

### successMeta
+ meta (successContent)

### successContent

+ code : `1` (number)
+ message: `success` (string)  - success

### successContentWithPagination

+ code : `1` (number)
+ message: `success` (string)  - success
+ pagination (object) - info about pagination

### four04content

+ code : `0` (number)
+ message: `Not Found` (array)  - not found message

### four09content

+ code : `0` (number)
+ message: `You are following user currently` (array)  - already following message

### failureContent

+ code : `0` (number)
+ message: `failure` (string)  - success

### ValidationError
+ meta (object)
    + code : `0` (number)
    + message (array)  - errors array