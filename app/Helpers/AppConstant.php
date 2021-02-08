<?php

const APP_NAME = 'App Name';

const USER_START_UUID_CHAR = 'AA';
const USER_START_UUID_DIGIT = '0001';

const USER_UUID = USER_START_UUID_CHAR.USER_START_UUID_DIGIT;
const USER_END_UUID_DIGIT = '9999';

const NONE = 0;
const NO = 0;
const YES = 1;

const ACTIVE = 1;
const DE_ACTIVE = 0;

const USER = 0;
const ADMIN = 1;
const SUPER_ADMIN = 1;

const PROFILE_PHOTO_PATH = 'profile-photos';

const PAGINATION_LENGTH = 5;
const ORDER_BY_COLUMN = 'id';
const ORDER_BY_ONLINE = 'is_online';
const ORDER_BY_DIRECTION = 'ASC';
const ORDER_BY_DESC = 'DESC';

const WEB = 'WEB';
const API = 'API';

const MIN_AGE = 18;

const DATE_FORMAT = 'd-m-Y';

const DEVICE_TYPES = ['ios', 'android'];

const FEMALE = 0;
const MALE = 1;
const OTHERS = 2;

const GENDER = [
    FEMALE => 'Female',
    MALE => 'Male',
    OTHERS => 'Others',
];
