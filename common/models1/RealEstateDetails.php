<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "real_estate_details".
 *
 * @property int $id
 * @property int $master_id
 * @property int $category 1->license , 2->plots
 * @property string $code
 * @property int $availability 0=>'occupied',1=>'not occupied'
 * @property int $customer_id
 * @property string $cost
 * @property double $rent_cost
 * @property double $off_rent
 * @property string $square_feet
 * @property string $comment
 * @property int $status
 * @property int $CB
 * @property int $UB
 * @property string $DOC
 * @property string $DOU
 *
 * @property Appointment[] $appointments
 * @property Appointment[] $appointments0
 * @property RealEstateMaster $master
 */
class RealEstateDetails extends \yii\db\ActiveRecord {

    public $total_amount;
    public $paid_amount;
    public $balance_amount;
    public $contract_start;
    public $contract_expiry;
    public $next_payment;

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'real_estate_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['type', 'master_id', 'category', 'availability', 'customer_id', 'square_feet', 'status', 'CB', 'UB', 'appointment_id', 'sponsor', 'sales_person', 'office_type'], 'integer'],
            [['cost', 'rent_cost', 'off_rent'], 'number'],
            [['comment'], 'string'],
            [['DOC', 'DOU', 'code'], 'safe'],
            [['master_id'], 'exist', 'skipOnError' => true, 'targetClass' => RealEstateMaster::className(), 'targetAttribute' => ['master_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'master_id' => 'Master ID',
            'category' => 'Category',
            'code' => 'Code',
            'availability' => 'Availability',
            'customer_id' => 'Customer ID',
            'appointment_id' => 'Appointment ID',
            'cost' => 'Cost',
            'rent_cost' => 'Rent Cost',
            'off_rent' => 'Off Rent',
            'square_feet' => 'Square Feet',
            'comment' => 'Comment',
            'status' => 'Status',
            'CB' => 'C B',
            'UB' => 'U B',
            'DOC' => 'D O C',
            'DOU' => 'D O U',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments() {
        return $this->hasMany(Appointment::className(), ['plot' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointments0() {
        return $this->hasMany(Appointment::className(), ['space_for_license' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMaster() {
        return $this->hasOne(RealEstateMaster::className(), ['id' => 'master_id']);
    }

    public function getTotal($id) {
        if ($id == '') {
            return '';
        } else {
            $appointment = Appointment::find()->where(['id' => $id])->one();
            if (empty($appointment)) {
                return '';
            } else {
                $payments = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                if (empty($payments)) {
                    return AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                } else {
                    return $payments->total_amount;
                }
            }
        }
    }

    public function getPaidAmount($id) {
        if ($id == '') {
            return '';
        } else {
            $appointment = Appointment::find()->where(['id' => $id])->one();
            if (empty($appointment)) {
                return '';
            } else {
                $payments = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                if (empty($payments)) {
                    return '';
                } else {
                    return $payments->amount_paid;
                }
            }
        }
    }

    public function getBalanceAmount($id) {
        if ($id == '') {
            return '';
        } else {
            $appointment = Appointment::find()->where(['id' => $id])->one();
            if (empty($appointment)) {
                return '';
            } else {
                $payments = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                if (empty($payments)) {
                    return AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                } else {
                    return $payments->balance_amount;
                }
            }
        }
    }

    public function getNextPaymentDate($id) {
        if ($id == '') {
            return '';
        } else {
            $appointment = Appointment::find()->where(['id' => $id])->one();
            if (empty($appointment)) {
                return '';
            } else {
                $cheque_details = ServiceChequeDetails::find()->where(['appointment_id' => $appointment->id])->andWhere(['>=', 'cheque_date', date("Y-m-d")])->one();
                if (empty($cheque_details)) {
                    return '';
                } else {
                    return $cheque_details->cheque_date;
                }
            }
        }
    }

    public function getExpiryDate($id) {
        if ($id == '') {
            return '';
        } else {
            $appointment = Appointment::find()->where(['id' => $id])->one();
            if (empty($appointment)) {
                return '';
            } else {
                if ($appointment->contract_end_date != '') {
                    return $appointment->contract_end_date;
                } else {
                    return '';
                }
            }
        }
    }

    public function getContractStartDate($id) {
        if ($id == '') {
            return '';
        } else {
            $appointment = Appointment::find()->where(['id' => $id])->one();
            if (empty($appointment)) {
                return '';
            } else {
                if ($appointment->contract_start_date != '') {
                    return $appointment->contract_start_date;
                } else {
                    return '';
                }
            }
        }
    }

    public function getSummary($data) {
        $total_amount = 0;
        $paid_amount = 0;
        $balance_amount = 0;
        $result = [];
        $arr = [];
        if (!empty($data)) {
            foreach ($data as $value) {
                if ($value->appointment_id != '') {
                    if (!in_array($value->appointment_id, $arr)) {
                        $arr[] = $value->appointment_id;
                    }
                }
            }
        }
        if (!empty($arr)) {
            foreach ($arr as $arr_val) {
                $appointment = Appointment::find()->where(['id' => $arr_val])->one();
                if (!empty($appointment)) {
                    $payment = PaymentMaster::find()->where(['appointment_id' => $appointment->id])->one();
                    if (!empty($payment)) {
                        $total_amount += $payment->total_amount;
                        $paid_amount += $payment->amount_paid;
                        $balance_amount += $payment->balance_amount;
                    } else {
                        $total_amount += AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                        $balance_amount += AppointmentService::find()->where(['appointment_id' => $appointment->id])->sum('total');
                    }
                }
            }
        }
        $result['total_amount'] = $total_amount;
        $result['paid_amount'] = $paid_amount;
        $result['balance_amount'] = $balance_amount;
        return $result;
    }

}
