import 'package:flutter/material.dart';
import 'package:flutter_map/flutter_map.dart';
import 'package:latlong2/latlong.dart';
import 'package:google_fonts/google_fonts.dart';
import 'package:flutter_riverpod/flutter_riverpod.dart';
import 'core/constants/app_colors.dart';
import 'core/constants/app_strings.dart';
import 'providers/passport_provider.dart';

class PassportTrackingScreen extends ConsumerWidget {
  const PassportTrackingScreen({super.key});

  String _translateStatus(String? status) {
    if (status == null || status.isEmpty) return "حالة غير معروفة";
    final s = status.toLowerCase();
    switch (s) {
      case 'pending':
        return 'قيد الانتظار';
      case 'processing':
        return 'قيد المعالجة';
      case 'printed':
        return 'تمت الطباعة';
      case 'ready':
        return 'جاهز للاستلام';
      case 'collected':
        return 'تم التسليم';
      case 'rejected':
        return 'مرفوض';
      default:
        return status;
    }
  }

  @override
  Widget build(BuildContext context, WidgetRef ref) {
    final passport = ref.watch(passportProvider).passportData;

    // Handle null state gracefully
    if (passport == null) {
      return Directionality(
        textDirection: TextDirection.rtl,
        child: Scaffold(
          appBar: AppBar(
            title: Text(
              AppStrings.trackingAppBarTitle,
              style: GoogleFonts.cairo(
                color: AppColors.darkNavyBlue,
                fontWeight: FontWeight.bold,
                fontSize: 18,
              ),
            ),
            leading: IconButton(
              icon: const Icon(Icons.arrow_forward),
              onPressed: () => Navigator.pop(context),
            ),
          ),
          body: Center(
            child: Text(
              "لم يتم العثور على بيانات الجواز",
              style: GoogleFonts.cairo(
                color: AppColors.greyText,
                fontSize: 16,
              ),
            ),
          ),
        ),
      );
    }

    // Since the API returns statusUpdates in descending order (latest first),
    // reversing the list will display them chronologically from top to bottom.
    final reversedUpdates = passport.statusUpdates?.reversed.toList() ?? [];

    return Directionality(
      textDirection: TextDirection.rtl,
      child: Scaffold(
        appBar: AppBar(
          title: Text(
            "${AppStrings.trackingAppBarTitle} - ${passport.serialNumber ?? ''}",
            style: GoogleFonts.cairo(
              color: AppColors.darkNavyBlue,
              fontWeight: FontWeight.bold,
              fontSize: 16,
            ),
          ),
          leading: IconButton(
            icon: const Icon(Icons.arrow_forward),
            onPressed: () {
              Navigator.pop(context);
            },
          ),
        ),
        body: Column(
          children: [
            Expanded(
              child: SingleChildScrollView(
                physics: const BouncingScrollPhysics(),
                padding: const EdgeInsets.all(20.0),
                child: Column(
                  crossAxisAlignment: CrossAxisAlignment.start,
                  children: [
                    // 1. Current Status Card
                    _buildCurrentStatusCard(passport),

                    const SizedBox(height: 30),

                    // 2. Tracking History Title
                    Text(
                      AppStrings.trackingHistoryTitle,
                      style: GoogleFonts.cairo(
                        color: AppColors.darkNavyBlue,
                        fontWeight: FontWeight.bold,
                        fontSize: 18,
                      ),
                    ),
                    const SizedBox(height: 20),

                    // 3. Dynamic Timeline Items
                    if (reversedUpdates.isNotEmpty)
                      ...reversedUpdates.asMap().entries.map((entry) {
                        final index = entry.key;
                        final status = entry.value;
                        final isLatest = index == reversedUpdates.length - 1; 
                        final isCompleted = !isLatest; 
                        final hasNext = index < reversedUpdates.length - 1;

                        final translatedStatus = _translateStatus(status.status);

                        IconData getIcon(String statusStr) {
                           if (statusStr.contains("طباعة")) return Icons.print;
                           if (statusStr.contains("إرسال") || statusStr.contains("ترحيل")) return Icons.local_shipping;
                           if (statusStr.contains("وصل") || statusStr.contains("جاهز")) return Icons.inventory_2_outlined;
                           if (statusStr.contains("تسليم") || statusStr.contains("استلام")) return Icons.how_to_reg;
                           return Icons.info_outline;
                        }

                        return TimelineItem(
                          title: translatedStatus,
                          date: status.createdAt?.split('T').first ?? "",
                          icon: getIcon(translatedStatus),
                          isCompleted: isCompleted,
                          hasNext: hasNext,
                          isCurrent: isLatest,
                        );
                      }).toList()
                    else
                      Text(
                        "لا توجد تحديثات متاحة حالياً",
                        style: GoogleFonts.cairo(color: AppColors.greyText),
                      ),
                  ],
                ),
              ),
            ),
            // Sticky Bottom Action Button
            _buildBottomActionButton(),
          ],
        ),
      ),
    );
  }

  Widget _buildCurrentStatusCard(passport) {
    return Container(
      padding: const EdgeInsets.all(16),
      decoration: BoxDecoration(
        color: AppColors.white,
        borderRadius: BorderRadius.circular(12),
        border: Border.all(color: AppColors.lightGreyBorder),
      ),
      child: Column(
        crossAxisAlignment: CrossAxisAlignment.start,
        children: [
          Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                AppStrings.currentStatusLabel,
                style: GoogleFonts.cairo(
                  color: AppColors.greyText,
                  fontSize: 12,
                ),
              ),
              Container(
                padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 4),
                decoration: BoxDecoration(
                  color: AppColors.lightGoldBg,
                  borderRadius: BorderRadius.circular(12),
                ),
                child: Text(
                  AppStrings.updatedNowBadge,
                  style: GoogleFonts.cairo(
                    color: AppColors.solidGold,
                    fontSize: 10,
                    fontWeight: FontWeight.w600,
                  ),
                ),
              ),
            ],
          ),
          const SizedBox(height: 12),

          // Main Status Text
          Text(
            (passport.statusUpdates != null && passport.statusUpdates!.isNotEmpty)
                ? _translateStatus(passport.statusUpdates!.first.status)
                : "لا توجد حالة",
            style: GoogleFonts.cairo(
              color: AppColors.solidGold,
              fontWeight: FontWeight.bold,
              fontSize: 18,
            ),
          ),
          const SizedBox(height: 8),

          // Location Row
          Row(
            children: [
              const Icon(
                Icons.business,
                color: AppColors.darkNavyBlue,
                size: 16,
              ),
              const SizedBox(width: 6),
              Text(
                passport.branch?.name ?? AppStrings.deliveryLocation,
                style: GoogleFonts.cairo(
                  color: AppColors.darkNavyBlue,
                  fontSize: 13,
                ),
              ),
            ],
          ),
          const SizedBox(height: 16),

          // Map Image Container with flutter_map
          Container(
            height: 120,
            width: double.infinity,
            decoration: BoxDecoration(
              borderRadius: BorderRadius.circular(8),
              border: Border.all(
                color: AppColors.lightGreyBorder.withAlpha(100),
              ),
            ),
            child: ClipRRect(
              borderRadius: BorderRadius.circular(8),
              child: Stack(
                fit: StackFit.expand,
                children: [
                  FlutterMap(
                    options: MapOptions(
                      initialCenter: const LatLng(15.3694, 44.1910), // Sana'a
                      initialZoom: 14.0,
                      interactionOptions: const InteractionOptions(
                        flags: InteractiveFlag.all & ~InteractiveFlag.rotate,
                      ),
                    ),
                    children: [
                      TileLayer(
                        urlTemplate:
                            'https://{s}.basemaps.cartocdn.com/rastertiles/voyager/{z}/{x}/{y}.png',
                        subdomains: const ['a', 'b', 'c', 'd'],
                        userAgentPackageName: 'com.yemen.passport_tracking',
                      ),
                    ],
                  ),
                  Positioned(
                    bottom: 8,
                    right: 8,
                    child: Container(
                      padding: const EdgeInsets.symmetric(
                        horizontal: 8,
                        vertical: 4,
                      ),
                      decoration: BoxDecoration(
                        color: AppColors.black.withAlpha(150),
                        borderRadius: BorderRadius.circular(4),
                      ),
                      child: Row(
                        children: [
                          const Icon(
                            Icons.directions,
                            color: AppColors.white,
                            size: 14,
                          ),
                          const SizedBox(width: 4),
                          Text(
                            AppStrings.viewOnMap,
                            style: GoogleFonts.cairo(
                              color: AppColors.white,
                              fontSize: 12,
                            ),
                          ),
                        ],
                      ),
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildBottomActionButton() {
    return SafeArea(
      child: Container(
        padding: const EdgeInsets.all(20),
        decoration: BoxDecoration(
          color: AppColors.white,
          boxShadow: [
            BoxShadow(
              color: AppColors.black.withAlpha(10),
              offset: const Offset(0, -2),
              blurRadius: 8,
            ),
          ],
        ),
        child: SizedBox(
          width: double.infinity,
          height: 55,
          child: ElevatedButton(
            onPressed: () {
              debugPrint("Booking Appt clicked");
            },
            child: Row(
              mainAxisAlignment: MainAxisAlignment.center,
              children: [
                const Icon(
                  Icons.calendar_today,
                  color: AppColors.white,
                  size: 20,
                ),
                const SizedBox(width: 10),
                Text(
                  AppStrings.bookAppointmentButton,
                  style: GoogleFonts.cairo(
                    color: AppColors.white,
                    fontWeight: FontWeight.bold,
                    fontSize: 16,
                  ),
                ),
              ],
            ),
          ),
        ),
      ),
    );
  }
}

class TimelineItem extends StatelessWidget {
  final String title;
  final String? subtitle;
  final String date;
  final IconData icon;
  final bool isCompleted;
  final bool isCurrent;
  final bool hasNext;

  const TimelineItem({
    super.key,
    required this.title,
    this.subtitle,
    required this.date,
    required this.icon,
    required this.isCompleted,
    required this.isCurrent,
    required this.hasNext,
  });

  @override
  Widget build(BuildContext context) {
    final Color iconCircleBg = isCompleted || isCurrent
        ? AppColors.solidGold
        : AppColors.white;
    final Color iconColor = isCompleted
        ? AppColors.white
        : (isCurrent ? AppColors.solidGold : AppColors.greyText);
    final Color titleColor = isCurrent
        ? AppColors.solidGold
        : (isCompleted ? AppColors.darkNavyBlue : AppColors.greyText);
    final Color lineColor = isCompleted
        ? AppColors.solidGold
        : AppColors.lightGreyBorder;

    return IntrinsicHeight(
      child: Row(
        crossAxisAlignment: CrossAxisAlignment.stretch,
        children: [
          // 1. Indicator (Far Right in RTL)
          SizedBox(
            width: 40,
            child: Column(
              children: [
                Container(
                  width: 32,
                  height: 32,
                  decoration: BoxDecoration(
                    color: isCurrent ? AppColors.white : iconCircleBg,
                    shape: BoxShape.circle,
                    border: Border.all(
                      color: isCompleted || isCurrent
                          ? AppColors.solidGold
                          : AppColors.lightGreyBorder,
                      width: 2,
                    ),
                    boxShadow: [
                      BoxShadow(
                        color: AppColors.black.withAlpha(
                          20,
                        ), // Approx 0.08 opacity
                        blurRadius: 8,
                        spreadRadius: 1,
                        offset: const Offset(0, 3),
                      ),
                    ],
                  ),
                  child: Center(child: Icon(icon, color: iconColor, size: 16)),
                ),
                if (hasNext)
                  Expanded(child: Container(width: 2, color: lineColor)),
              ],
            ),
          ),
          const SizedBox(width: 12),

          // 2. Checkmark (Middle)
          SizedBox(
            width: 24,
            child: Column(
              mainAxisAlignment: MainAxisAlignment.start,
              children: [
                if (isCompleted)
                  const Padding(
                    padding: EdgeInsets.only(top: 4.0),
                    child: Icon(
                      Icons.check_circle_outline,
                      color: AppColors.solidGold,
                      size: 20,
                    ),
                  ),
              ],
            ),
          ),
          const SizedBox(width: 12),

          // 3. Content (Left Side in RTL)
          Expanded(
            child: Padding(
              padding: const EdgeInsets.only(bottom: 30.0),
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                mainAxisAlignment: MainAxisAlignment.start,
                children: [
                  Text(
                    title,
                    style: GoogleFonts.cairo(
                      color: titleColor,
                      fontWeight: isCurrent || isCompleted
                          ? FontWeight.bold
                          : FontWeight.normal,
                      fontSize: 14,
                    ),
                  ),
                  if (subtitle != null) ...[
                    const SizedBox(height: 2),
                    Text(
                      subtitle!,
                      style: GoogleFonts.cairo(
                        color: AppColors.solidGold.withAlpha(200),
                        fontSize: 12,
                      ),
                    ),
                  ],
                  const SizedBox(height: 4),
                  Text(
                    date,
                    style: GoogleFonts.cairo(
                      color: AppColors.greyText,
                      fontSize: 12,
                    ),
                  ),
                ],
              ),
            ),
          ),
        ],
      ),
    );
  }
}
