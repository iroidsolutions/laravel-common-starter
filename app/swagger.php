<?php
/**
 *  @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Common Starter"
 *  )
 *  @OA\SecurityScheme(type="http", securityScheme="BearerAuth", scheme="bearer", bearerFormat="JWT"),
*/




/**
 * @OA\Post(
 * path="/login",
 * summary="Sign in",
 * description="Login by email, password",
 * operationId="authLogin",
 * tags={"Auth"},
 * @OA\RequestBody(
 *    required=true,
 *    description="Pass user credentials",
 *    @OA\JsonContent(
 *       required={"email","password"},
 *       @OA\Property(property="email", type="string", format="email", example="iroid.test1@gmail.com"),
 *       @OA\Property(property="password", type="string", format="password", example="password"),
 *    ),
 * ),
 * @OA\Response(
 *    response=422,
 *    description="Wrong credentials response",
 *    @OA\JsonContent(
 *       @OA\Property(property="message", type="string", example="Sorry, wrong email address or password. Please try again")
 *        )
 *     )
 * )
 */





/**
 * @OA\Post(
 *     path="/register",
 *     summary="Register user",
 *     tags={"Auth"},
 *     security={},
 *     @OA\RequestBody(description="", required=true,
 *         @OA\MediaType(mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(property="first_name", type="string", minimum="4", example="iRoid",description="first name must be atleast 4chars"),
 *                 @OA\Property(property="last_name", type="string", minimum="4", example="testing",description="last name must be atleast 4chars"),
 *                 @OA\Property(property="email", type="string", format="email", example="iroid.test1@gmail.com"),
 *                 @OA\Property(property="password", type="string", minimum="8", example="password"),
 *                 @OA\Property(property="password_confirmation", type="string", minimum="8", example="password"),
 *                 @OA\Property(property="time_zone", type="string", example="Asia/Kolkata"),
 *                 @OA\Property(property="profile_pic", type="string", format="binary"),
 *                 required={"email", "first_name","last_name", "password", "password_confirmation", "profile_pic"}
 *             ),
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Sign up successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */




 /**
 * @OA\Post(
 *  path="/logout",
 *  tags={"Auth"},
 *  security={{ "BearerAuth"={} }},
 *  summary="User logout",
 *     @OA\RequestBody(description="", required=true,
 *         @OA\MediaType(mediaType="application/json",
 *             @OA\Schema(
 *                 @OA\Property(property="device_id", type="string", example="7e2848ed2efc7d22170dc6948fe718b5d7dae11c"),
 *                 required={"device_id"}
 *             ),
 *         ),
 *     ),
 *  @OA\Response(response="200", description="Logout successfuly",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 *  @OA\Response(response="422", description="Invalid Request params",
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */

/**
     * @OA\Post(
     *  path="/refresh-token",
     *  tags={"Auth"},
     *  summary="Refresh Token",
     *  @OA\RequestBody(description="", required=true,
     *      @OA\MediaType(mediaType="application/json",
     *          @OA\Schema(
     *              @OA\Property(property="refresh_token", type="string", example="def5020075819e4748adefe1f860566c3b41437f2b7e396db025b4d384e6b5db5911a3cfc224e2b2471b111be6113e5a807aac58edc41634ec7babd26d4482de8412402ec1798f6c2e793249d8993e3b02506de8d1bbcd45fe551cd23c5695d2f79e11dec3e6502ff31588f5deefe65885041108513b40321afe392628cd0867cb4d5df1a023c30f5d4f2dc4c87f2c140a6bc625e0d5fa98ce2b20f15492ecca590ada4557540e7231c33587eb434cc027ec7e5e0d07d6d9bd16d7c1520110093e5d228707fc8ebae8020d062cea8cce01eeb3344fcf9854fabcb89660d68966a05c878656bb9acc5df678156e9729278152dae00f6198660faebe52beb74c629aef8ed4cf49ab0ca86978679a17cc273afe8ca3f1c86f989c7c01f017d1479002885640d68e01b59df5bdce5438306195ee7c51ca72b7e8149d3ed3b94402f528569956ca833b074aa74cb42098df96023e9f1bc0b0c3bdddd233337130633239388bf1"),
     *          )
     *      )
     *  ),
     *  @OA\Response(response="200", description="Refresh token generated successfully",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     *  @OA\Response(response="401", description="Token is either expired or revoked. In such cases, redirect the user to login screen",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     *
     */

/**
     *  @OA\Get(path="/user", summary="Get user profile",
     *     tags={"Common"}, security={{ "BearerAuth"={} }},
     *     @OA\Response(response="200", description="Profile retreived successfully",
     *         @OA\MediaType(mediaType="application/json")
     *     ),
     *     @OA\Response(response="404", description="User not found",
     *         @OA\MediaType(mediaType="application/json")
     *     ),
     *     @OA\Response(response="422", description="Validation error",
     *         @OA\MediaType(mediaType="application/json")
     *     ),
     *  )
     */



/**
 * @OA\Post(
 *     path="/user/update",
 *     summary="Update profile info",
 *     tags={"Common"},
 *     security={{ "BearerAuth"={} }},
 *     @OA\RequestBody(description="", required=true,
 *         @OA\MediaType(mediaType="multipart/form-data",
 *             @OA\Schema(
 *                 @OA\Property(property="first_name", type="string", minimum="4", example="iRoid",description="first name must be atleast 4chars"),
 *                 @OA\Property(property="last_name", type="string", minimum="4", example="testing",description="last name must be atleast 4chars"),
 *                 @OA\Property(property="time_zone", type="string", example="Asia/Kolkata"),
 *                 @OA\Property(property="profile_pic", type="string", format="binary"),
 *                 required={"first_name","last_name", "profile_pic"}
 *             ),
 *         ),
 *     ),
 *     @OA\Response(response="200", description="Sign up successfully",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *     @OA\Response(response="422", description="Validation error",
 *         @OA\MediaType(mediaType="application/json")
 *     ),
 *  )
 */





?>
