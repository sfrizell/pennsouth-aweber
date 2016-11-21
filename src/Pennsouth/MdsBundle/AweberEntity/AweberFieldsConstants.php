<?php
/**
 * AweberFieldsConstants.php
 * User: sfrizell
 * Date: 11/6/16
 *  Function:
 */

namespace Pennsouth\MdsBundle\AweberEntity;


class AweberFieldsConstants
{
        const PATH_TO_AWEBER_UNDER_VENDOR                    = '/vendor/aweber/aweber/aweber_api/aweber_api.php';
       const AWEBER_PENNSOUTH_NEWSLETTER_LIST = 'Penn South Newsletter'; // Unique List ID: awlist3774632
       const EMERGENCY_NOTICES_FOR_RESIDENTS = 'Penn South Emergency Info Only'; // Unique List ID: awlist4464610 ; list_id is stripped of the 'awlist' prefix, just the # portion

       const CUSTOM_FIELDS                  = array('BUILDING' => 'Penn_South_Building',
                                                    'FLOOR_NUMBER' => 'Floor_Number',
                                                    'APARTMENT' => 'Apartment');

       const BUILDING                                           = 'Penn_South_Building';
       const FLOOR_NUMBER                                       = 'Floor_Number';
       const APARTMENT                                          = 'Apartment';
       const RESIDENT_CATEGORY                                  = 'resident_category';
       const TODDLER_ROOM_MEMBER                                = 'toddler_room_member';
       const YOUTH_ROOM_MEMBER                                  = 'youth_room_member';
       const CERAMICS_MEMBER                                    = 'ceramics_member';
       const WOODWORKING_MEMBER                                 = 'woodworking_member';
       const GYM_MEMBER                                         = 'gym_member';
       const GARDEN_MEMBER                                      = 'garden_member';
       const PARKING_LOT_LOCATION                               = 'parking_lot_location';
       const VEHICLE_REG_EXP_DAYS_LEFT                          = 'vehicle_reg_exp_days_left';
       const HOMEOWNER_INS_EXP_DAYS_LEFT                        = 'homeowner_ins_exp_days_left';
       const IS_DOG_IN_APT                                      = 'is_dog_in_apt';
       const STORAGE_LOCKER_CLOSET_BLDG_NUM                     = 'storage_locker_closet_bldg_num';
       const STORAGE_LOCKER_NUM                                 = 'storage_locker_num';
       const STORAGE_CLOSET_FLOOR_NUM                           = 'storage_closet_floor_num';
       const BIKE_RACK_BLDG                                     = 'bike_rack_bldg';
       const BIKE_RACK_ROOM                                     = 'bike_rack_room';
       const PENN_SOUTH_AWEBER_ACCOUNT                          = 936765;
       const ADMINS_MDS_TO_AWEBER_LIST_ID                       = 4459191; // Aweber subscriber list of Penn South Administrators to receive emails about the running of this program to sync Aweber to MDS
       const PENNSOUTH_NEWSLETTER_LIST_ID                       = 3774632;
       const PENNSOUTH_EMERGENCY_NOTICES_FOR_RESIDENTS_LIST_ID  = 4464610;

       const PENNSOUTH_NEWSLETTER_LIST_URL                      = "/accounts/" . self::PENN_SOUTH_AWEBER_ACCOUNT . "/lists/" . self::PENNSOUTH_NEWSLETTER_LIST_ID;
       const PENNSOUTH_EMERGENCY_NOTICES_LIST_URL               = "/accounts/" . self::PENN_SOUTH_AWEBER_ACCOUNT . "/lists/" . self::PENNSOUTH_EMERGENCY_NOTICES_FOR_RESIDENTS_LIST_ID;

}